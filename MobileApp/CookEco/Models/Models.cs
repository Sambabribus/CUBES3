using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using SQLite;
using System.Text.Json.Serialization;
using System.Text.Json;

namespace CookEco.Models
{
    public class User
    {
        [PrimaryKey, AutoIncrement]
        public int Id { get; set; }
        [JsonPropertyName("username")]
        public string Username { get; set; }
        [JsonPropertyName("password")]
        public string Password { get; set; }
    }

    public class UsersResponse
    {
        [JsonPropertyName("records")]
        public List<User> Records { get; set; }
    }


    public class Comment
    {
        public int Id { get; set; }
        public int UserId { get; set; }
        public int RecipeId { get; set; }
        public string CreationDate { get; set; }
        public string Content { get; set; }
    }

    public class CommentsResponse
    {
        public List<Comment> Records { get; set; }
    }

    public class Recipe
    {
        [PrimaryKey, AutoIncrement]
        public int Id { get; set; }

        [JsonPropertyName("title")]
        public string Title { get; set; }

        [JsonPropertyName("description")]
        public string Description { get; set; }

        [JsonPropertyName("prep_time")]
        public int PreparationTime { get; set; }

        [JsonPropertyName("cook_time")]
        public int CookingTime { get; set; }

        [JsonPropertyName("serves")]
        public int Serves { get; set; }

        [JsonPropertyName("creation_date")]
        public string CreationDate { get; set; }

        [JsonPropertyName("user_id")]
        public int UserId { get; set; }

        [JsonIgnore]
        public string ImagePath { get; set; }

    }
    public class RecipesResponse
    {
        [JsonPropertyName("records")]
        public List<Recipe> Records { get; set; }
    }

}