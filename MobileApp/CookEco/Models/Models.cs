using System;
using System.Collections.Generic;
using System.Text.Json.Serialization;
using SQLite;

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
        [PrimaryKey, AutoIncrement]
        public int Id { get; set; }

        [JsonPropertyName("user_id")]
        public int UserId { get; set; }

        [JsonPropertyName("recipe_id")]
        public int RecipeId { get; set; }

        [JsonPropertyName("creation_date")]
        public string CreationDate { get; set; }

        [JsonPropertyName("content")]
        public string Content { get; set; }
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

        [JsonPropertyName("image")]
        public string ImagePath { get; set; } 
        public string FullImagePath => ImagePath.StartsWith("http") ? ImagePath : $"http://{ImagePath}";
    }

    public class RecipesResponse
    {
        [JsonPropertyName("records")]
        public List<Recipe> Records { get; set; }
    }
}