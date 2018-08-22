using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using demo1.Models;
/**
 * 页面通知
 * */
namespace demo1.Controllers
{

    public class WebPayBackCallBakeController : Controller
    {
        public IActionResult WebPayBackCall()
        {
        
            return View();
        }

    }
}
