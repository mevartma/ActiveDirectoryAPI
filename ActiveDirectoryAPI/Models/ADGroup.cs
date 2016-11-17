using System;
using System.Collections.Generic;
using System.DirectoryServices.AccountManagement;
using System.Linq;
using System.Web;

namespace ActiveDirectoryAPI.Models
{
    public class ADGroup
    {
        public bool IsSecurityGroup { get; set; }
        public GroupScope GroupScope { get; set; }
        public string Description { get; set; }
        public string DisplayName { get; set; }
        public Guid Guid { get; set; }
        public string DistinguishedName { get; set; }
        public string Name { get; set; }
    }
}