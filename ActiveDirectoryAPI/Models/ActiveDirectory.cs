using Newtonsoft.Json.Linq;
using System;
using System.Collections;
using System.Collections.Generic;
using System.DirectoryServices;
using System.DirectoryServices.AccountManagement;
using System.Linq;
using System.Net;
using System.Web;

namespace ActiveDirectoryAPI.Models
{
    public class ActiveDirectory
    {

        private string sDomain = "BETAMEDIA.LOCAL";
        //private string sDefaultOU = "OU=TLV Users & Computers,DC=BETAMEDIA,DC=LOCAL";
        private string sDefaultRootOU = "DC=BETAMEDIA,DC=LOCAL";

        private PrincipalContext GetPrincipalContext()
        {
            PrincipalContext oPrincipalContext = new PrincipalContext(ContextType.Domain, sDomain, sDefaultRootOU);
            return oPrincipalContext;
        }

        private PrincipalContext GetPrincipalContext(string sOU)
        {
            PrincipalContext oPrincipalContext = new PrincipalContext(ContextType.Domain, sDomain, sOU);
            return oPrincipalContext;
        }

        private UserPrincipal GetUser(string sUserName)
        {
            PrincipalContext oPrincipalContext = GetPrincipalContext();
            UserPrincipal oUserPrincipal = UserPrincipal.FindByIdentity(oPrincipalContext, sUserName);
            return oUserPrincipal;
        }

        private GroupPrincipal GetGroup(string sGroupName)
        {
            PrincipalContext oPrincipalContext = GetPrincipalContext();
            GroupPrincipal oGroupPrincipal = GroupPrincipal.FindByIdentity(oPrincipalContext, sGroupName);
            return oGroupPrincipal;
        }

        private void EnableUserAccount(string sUserName)
        {
            UserPrincipal oUserPrincipal = GetUser(sUserName);
            oUserPrincipal.Enabled = true;
            oUserPrincipal.Save();
        }

        private void DisableUserAccount(string sUserName)
        {
            UserPrincipal oUserPrincipal = GetUser(sUserName);
            oUserPrincipal.Enabled = false;
            oUserPrincipal.Save();
        }

        private void UnlockUserAccount(string sUserName)
        {
            UserPrincipal oUserPrincipal = GetUser(sUserName);
            oUserPrincipal.UnlockAccount();
            oUserPrincipal.Save();
        }

        private bool IsUserGroupMember(string sUserName, string sGroupName)
        {
            UserPrincipal oUserPrincipal = GetUser(sUserName);
            GroupPrincipal oGroupPrincipal = GetGroup(sGroupName);
            if (oUserPrincipal != null && oGroupPrincipal != null)
            {
                return oGroupPrincipal.Members.Contains(oUserPrincipal);
            }
            else
            {
                return false;
            }
        }

        private bool AddUserToGroup(string sUserName, string sGroupName)
        {
            try
            {
                UserPrincipal oUserPrincipal = GetUser(sUserName);
                GroupPrincipal oGroupPrincipal = GetGroup(sGroupName);
                if (oUserPrincipal != null && oGroupPrincipal != null)
                {
                    if (!IsUserGroupMember(sUserName, sGroupName))
                    {
                        oGroupPrincipal.Members.Add(oUserPrincipal);
                        oGroupPrincipal.Save();
                    }
                }
                return true;
            }
            catch
            {
                return false;
            }
        }

        private bool RemoveUserFromGroup(string sUserName, string sGroupName)
        {
            try
            {
                UserPrincipal oUserPrincipal = GetUser(sUserName);
                GroupPrincipal oGroupPrincipal = GetGroup(sGroupName);
                if (oUserPrincipal != null && oGroupPrincipal != null)
                {
                    if (IsUserGroupMember(sUserName, sGroupName))
                    {
                        oGroupPrincipal.Members.Remove(oUserPrincipal);
                        oGroupPrincipal.Save();
                    }
                }
                return true;
            }
            catch
            {
                return false;
            }
        }

        private ArrayList GetUserGroups(string sUserName)
        {
            ArrayList myItems = new ArrayList();
            UserPrincipal oUserPrincipal = GetUser(sUserName);

            PrincipalSearchResult<Principal> oPrincipalSearchResult = oUserPrincipal.GetGroups();

            foreach (Principal oResult in oPrincipalSearchResult)
            {
                myItems.Add(oResult.Name);
            }
            return myItems;
        }

        /*Checks*/

        private bool CheckUserName(string sUserName, List<ADUser> allusers)
        {
            foreach (ADUser usr in allusers)
            {
                if (usr.SamAccountName == sUserName)
                {
                    return false;
                }
            }
            return true;
        }

        private bool CheckEXT(string uext, List<ADUser> alluser)
        {
            foreach (ADUser usr in alluser)
            {
                bool g = usr.VoiceTelephoneNumber.Contains(uext);
                if (g == true)
                {
                    return true;
                }
            }
            return false;
        }

        /*Checks*/

        /*Genereates*/

        private string GenPass()
        {
            string result = "";
            DirectoryEntry child = new DirectoryEntry("LDAP://BETAMEDIA.LOCAL");
            int minPwdLength = (int)child.Properties["minPwdLength"].Value;
            int pwdProperties = (int)child.Properties["pwdProperties"].Value;
            result = System.Web.Security.Membership.GeneratePassword(minPwdLength, pwdProperties);
            return result;
        }

        private string GenUserName(string fname, string lname)
        {
            string result = "";
            string uname = fname.ToLower();
            string fff = lname.ToLower();
            List<ADUser> allusers = PublicGetUsers();
            for (int i =0; i<= fff.Length;i++)
            {
                uname = uname + fff[i].ToString();
                var res = CheckUserName(uname, allusers);
                if (res == true)
                {
                    result = uname;
                    break;
                }
            }
            return result;
        }

        private string GenEmail(string sfname, string slname, string domain)
        {
            string result = "";
            string flleter = slname[0].ToString();
            result = sfname.ToLower() + "." + flleter.ToLower() + domain.ToLower();
            return result;
        }

        /*Genereates*/


        /*ops*/

        private bool CreateUser(string sFrname, string sLrname, string sFsname, string sLsname, string sDomain, string sExt, string sOU)
        {
            if (sFrname == "" || sLrname == "" || sFsname == "" || sLsname == "" || sDomain == "")
            {
                return false;
            }
            string sUserName = GenUserName(sFrname, sLrname);
            string sEmailAddr = GenEmail(sFrname, sLrname, sDomain);
            string sPassword = GenPass();
            PrincipalContext oPrincipalContext = GetPrincipalContext(sOU);
            UserPrincipal oUserPrincipal = new UserPrincipal(oPrincipalContext);
            oUserPrincipal.SamAccountName = sUserName;
            oUserPrincipal.SetPassword(sPassword);
            oUserPrincipal.EmailAddress = sEmailAddr;
            oUserPrincipal.VoiceTelephoneNumber = sExt;
            oUserPrincipal.Enabled = true;
            oUserPrincipal.UserPrincipalName = sUserName + "@BETAMEDIA.LOCAL";
            oUserPrincipal.GivenName = sFrname;
            oUserPrincipal.Surname = sLrname;
            oUserPrincipal.DisplayName = sFrname + " " + sLrname;
            oUserPrincipal.Description = sFsname + " " + sLsname;
            try
            {
                oUserPrincipal.Save();
                return true;
            }
            catch
            {
                return false;
            }
        }

        private bool CopyUser(string cFrom, string sFrname, string sLrname, string sFsname, string sLsname, string sDomain, string sExt, string sOU)
        {
            if (sFrname == "" || sLrname == "" || sFsname == "" || sLsname == "" || sDomain == "")
            {
                return false;
            }
            string sUserName = GenUserName(sFrname, sLrname);
            /*string sEmailAddr = GenEmail(sFrname, sLrname, sDomain);*/
            bool result = CreateUser(sFrname, sLrname, sFsname, sLsname, sDomain, sExt, sOU);
            if (result == false)
            {
                return false;
            }
            else
            {
                ArrayList scGroup = GetUserGroups(cFrom);
                foreach (var sGName in scGroup)
                {
                    bool gResult = AddUserToGroup(sUserName, sGName.ToString());
                }
                return true;
            }
        }


        /*ops*/

        /* public */
        public List<ADUser> PublicGetUsers()
        {
            PrincipalContext oPrincipalContext = GetPrincipalContext();
            UserPrincipal oUserPrincipal = new UserPrincipal(oPrincipalContext);
            PrincipalSearcher oPrincipalSearcher = new PrincipalSearcher(oUserPrincipal);
            List<ADUser> allUsers = new List<ADUser>();
            foreach (UserPrincipal u in oPrincipalSearcher.FindAll())
            {
                ADUser user = new ADUser();
                if (u.Enabled == false)
                {
                    continue;
                }
                else if (u.Enabled == true)
                {
                    user.GivenName = u.GivenName;
                    user.MiddleName = u.MiddleName;
                    user.Surname = u.Surname;
                    user.EmailAddress = u.EmailAddress;
                    user.VoiceTelephoneNumber = u.VoiceTelephoneNumber;
                    user.EmployeeId = u.EmployeeId;
                    user.Enabled = u.Enabled.Value;
                    user.HomeDirectory = u.HomeDirectory;
                    user.HomeDrive = u.HomeDrive;
                    user.Description = u.Description;
                    user.DisplayName = u.DisplayName;
                    user.SamAccountName = u.SamAccountName;
                    user.UserPrincipalName = u.UserPrincipalName;
                    user.DistinguishedName = u.DistinguishedName;
                    user.Name = user.Name;
                    allUsers.Add(user);
                }
            }
            return allUsers;
        }

        public List<ADGroup> PublicGetGroups()
        {
            PrincipalContext oPrincipalContext = GetPrincipalContext();
            GroupPrincipal oGroupPrincipal = new GroupPrincipal(oPrincipalContext);
            PrincipalSearcher srch = new PrincipalSearcher(oGroupPrincipal);
            List<ADGroup> allGroups = new List<ADGroup>();
            foreach (GroupPrincipal g in srch.FindAll())
            {
                ADGroup group = new ADGroup();
                group.IsSecurityGroup = g.IsSecurityGroup.Value;
                group.Description = g.Description;
                group.DisplayName = g.DisplayName;
                group.DistinguishedName = g.DistinguishedName;
                group.Guid = g.Guid.Value;
                group.Name = g.Name;
                group.GroupScope = g.GroupScope.Value;
                allGroups.Add(group);
            }
            return allGroups;
        }

        public List<sip> PublicGetSips()
        {
            WebClient c = new WebClient();
            var data = c.DownloadString("http://192.168.1.29:5000/");
            JArray ss = JArray.Parse(data) as JArray;
            dynamic extes = ss;
            List<sip> ess = new List<sip>();
            List<ADUser> users = PublicGetUsers();
            foreach (dynamic ext in extes)
            {
                sip test = new sip();
                test.Extention = ext.objectname;
                test.IPAddr = ext.ipaddress;
                test.Status = ext.status;
                bool re = CheckEXT(test.Extention, users);
                if (re == false)
                {
                    test.Extention = test.Extention + " - " + test.IPAddr;
                    ess.Add(test);
                }
            }
            return ess;
        }

        public ADUser PublicGetUser(string sUserName)
        {
            UserPrincipal u = GetUser(sUserName);
            ADUser returnUser = new ADUser();
            returnUser.Description = u.Description;
            returnUser.DisplayName = u.DisplayName;
            returnUser.DistinguishedName = u.DistinguishedName;
            returnUser.EmailAddress = u.EmailAddress;
            returnUser.EmployeeId = u.EmployeeId;
            returnUser.Enabled = u.Enabled.Value;
            returnUser.GivenName = u.GivenName;
            returnUser.HomeDirectory = u.HomeDirectory;
            returnUser.HomeDrive = u.HomeDrive;
            returnUser.MiddleName = u.MiddleName;
            returnUser.Name = u.Name;
            returnUser.SamAccountName = u.SamAccountName;
            returnUser.Surname = u.Surname;
            returnUser.UserPrincipalName = u.UserPrincipalName;
            returnUser.VoiceTelephoneNumber = u.VoiceTelephoneNumber;
            return returnUser;
        }
    }
}