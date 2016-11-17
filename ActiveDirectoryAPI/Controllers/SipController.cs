using ActiveDirectoryAPI.Models;
using Newtonsoft.Json.Linq;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Web.Http;

namespace ActiveDirectoryAPI.Controllers
{
    public class SipController : ApiController
    {
        ActiveDirectory ad = new ActiveDirectory();

        public List<sip> GetSips()
        {
            return ad.PublicGetSips();
        }
    }
}
