using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using SQLite;
using System.Text.Json.Serialization;

namespace CookEco.Models
{
        public class User
        {
        [PrimaryKey, AutoIncrement]
        public int Id { get; set; }
        [JsonPropertyName("username_user")]
        public string Username { get; set; }
        [JsonPropertyName("pwd_user")]
        public string Password { get; set; }
        }

        public class UsersResponse
        {
        [JsonPropertyName("records")]
        public List<User> Records { get; set; }
        }

    public class Recipe
        {
            [PrimaryKey, AutoIncrement]
            public int Id { get; set; }
            public string Title { get; set; }
            public string Description { get; set; }
            public string ImagePath { get; set; }
        }
}
