using System;
using System.Net.Http;
using System.Text.Json;
using System.Threading.Tasks;
using CookEco.Models;
using SQLite;

namespace CookEco.Services
{
    internal class FetchUserRecipe
    {
        private readonly HttpClient httpClient;

        public FetchUserRecipe()
        {
            httpClient = new HttpClient { BaseAddress = new Uri("http://api.snsekken.com") };
        }

        public async Task<string> AddAllRecipes()
        {
            var response = await httpClient.GetAsync("/index.php/recipes/");
            var jsonString = await response.Content.ReadAsStringAsync();
            var recipesResponse = JsonSerializer.Deserialize<RecipesResponse>(jsonString);
            if (recipesResponse?.Records != null)
            {
                foreach (var recipe in recipesResponse.Records)
                {
                    await ManagerDB.SaveRecipeAsync(recipe);
                }
            }

            return "Recipes added to the database";
        }
    }
}
