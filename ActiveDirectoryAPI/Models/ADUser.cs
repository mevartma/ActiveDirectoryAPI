﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace ActiveDirectoryAPI.Models
{
    public class ADUser
    {
        public string GivenName { get; set; }
        public string MiddleName { get; set; }
        public string Surname { get; set; }
        public string EmailAddress { get; set; }
        public string VoiceTelephoneNumber { get; set; }
        public string EmployeeId { get; set; }
        public bool Enabled { get; set; }
        public string HomeDirectory { get; set; }
        public string HomeDrive { get; set; }
        public string Description { get; set; }
        public string DisplayName { get; set; }
        public string SamAccountName { get; set; }
        public string UserPrincipalName { get; set; }
        public string DistinguishedName { get; set; }
        public string Name { get; set; }
    }
}