using System;
using System.Collections.Generic;
using System.Web;

namespace Paycenter_sdk.lib
{
    public class PayCenterException : Exception 
    {
        public PayCenterException(string msg): base(msg) 
        {

        }
     }
}