using ActiveDirectoryAPI.Models;
using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Web.Http;

namespace ActiveDirectoryAPI.Controllers
{
    public class ADOUController : ApiController
    {
        public List<ADOU> Get()
        {
            List<ADOU> ou = new List<ADOU>();
            string json = File.ReadAllText(@"C:\ASP Projecs\ActiveDirectoryAPI\ActiveDirectoryAPI\jsondata\ouDB.json");
            JsonTextReader reader = new JsonTextReader(new StringReader(json));
            reader.SupportMultipleContent = true;
            while (true)
            {
                if (!reader.Read())
                {
                    break;
                }

                JsonSerializer serializer = new JsonSerializer();
                ou = serializer.Deserialize<List<ADOU>>(reader);
            }
            return ou;
        }
    }
}
