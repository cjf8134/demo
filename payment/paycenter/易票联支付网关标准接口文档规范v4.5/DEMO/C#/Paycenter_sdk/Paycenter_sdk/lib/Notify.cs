using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Text;
using System.Collections;

namespace Paycenter_sdk.lib
{
    public class Notify
    {
        public Page page { get; set; }
        public Notify(Page page)
        {
            this.page = page;
        }

        public PayCenterData GetNotifyData() {
            PayCenterData data = null;
            System.IO.Stream s = page.Request.InputStream;
            int count = 0;
            byte[] buffer = new byte[1024];
            StringBuilder builder = new StringBuilder();
            while ((count = s.Read(buffer, 0, 1024)) > 0)
            {
                builder.Append(Encoding.UTF8.GetString(buffer, 0, count));
            }
            s.Flush();
            s.Close();
            s.Dispose();

            Log.Info(this.GetType().ToString(), "Receive data from WeChat : " + builder.ToString());

            SortedList table = Param(builder.ToString());
            if (table != null)
            {
                data = new PayCenterData();
                foreach (DictionaryEntry De in table)
                {
                    data.SetValue(De.Key + "", HttpUtility.UrlDecode(De.Value.ToString()) + "");
                }
            }
            else
            {
                Log.Info(this.GetType().ToString(), "没有收到传递的参数值");
                throw new PayCenterException("没有收到传递的参数值");
            }

            //2、验证签名
            if (data.CheckSign())
            {
                Log.Info(this.GetType().ToString(), "签名验证成功");
                
            }
            else
            {
                Log.Error(this.GetType().ToString(), "PayCenterData签名验证错误!");
                throw new PayCenterException("PayCenterData签名验证错误!");
            } 

            return data;
        }



        private SortedList Param(string POSTStr)
        {
            SortedList SortList = new SortedList();
            int index = POSTStr.IndexOf("&");
            string[] Arr = { };
            if (index != -1) //参数传递不只一项
            {
                Arr = POSTStr.Split('&');
                for (int i = 0; i < Arr.Length; i++)
                {
                    int equalindex = Arr[i].IndexOf('=');
                    string paramN = Arr[i].Substring(0, equalindex);
                    string paramV = Arr[i].Substring(equalindex + 1);
                    if (!SortList.ContainsKey(paramN)) //避免用户传递相同参数
                    { SortList.Add(paramN, paramV); }
                    else //如果有相同的，一直删除取最后一个值为准
                    { SortList.Remove(paramN); SortList.Add(paramN, paramV); }
                }
            }
            else //参数少于或等于1项
            {
                int equalindex = POSTStr.IndexOf('=');
                if (equalindex != -1)
                { //参数是1项
                    string paramN = POSTStr.Substring(0, equalindex);
                    string paramV = POSTStr.Substring(equalindex + 1);
                    SortList.Add(paramN, paramV);

                }
                else //没有传递参数过来
                { SortList = null; }
            }
            return SortList;
        }
    }
}