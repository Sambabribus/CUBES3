using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using SQLite;

namespace CookEco.Models
{
        public class User
        {
            [PrimaryKey, AutoIncrement]
            public int Id { get; set; }
            public string Username { get; set; }
            public string Password { get; set; }
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
