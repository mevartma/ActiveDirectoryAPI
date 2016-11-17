using ActiveDirectoryAPI.Models;
using System;
using System.Collections.Generic;
using System.DirectoryServices;
using System.DirectoryServices.AccountManagement;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Web.Http;
using System.Web.Http.Cors;

namespace ActiveDirectoryAPI.Controllers
{
    [EnableCors(origins:"*",headers:"*",methods:"*")]
    public class ADUserController : ApiController
    {
        ActiveDirectory ad = new ActiveDirectory();
               
        public List<ADUser> GetUsers()
        {
            return ad.PublicGetUsers();
        }

        public ADUser GetUser(string sUserName)
        {
            return ad.PublicGetUser(sUserName);
        }
    }
}
