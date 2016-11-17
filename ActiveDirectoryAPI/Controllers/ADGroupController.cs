using ActiveDirectoryAPI.Models;
using System;
using System.Collections.Generic;
using System.DirectoryServices.AccountManagement;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Web.Http;

namespace ActiveDirectoryAPI.Controllers
{
    public class ADGroupController : ApiController
    {
        ActiveDirectory ad = new ActiveDirectory();

        public List<ADGroup> GetGroups()
        {
            return ad.PublicGetGroups();
        }
    }
}
