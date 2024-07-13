using CookEco.Models;
using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Text.Json;
using System.Threading.Tasks;

namespace CookEco.Services
{
    internal class FetchUserComments
    {
        private readonly HttpClient httpClient;

        public FetchUserComments()
        {
            httpClient = new HttpClient { BaseAddress = new Uri("http://192.168.0.29/") };
        }

        public async Task<string> AddAllComments()
        {
            var response = await httpClient.GetAsync("/newAPI/CUBES3/index.php/comments");
            var jsonString = await response.Content.ReadAsStringAsync();
            try
            {
                var comments = JsonSerializer.Deserialize<List<Comment>>(jsonString);

                if (comments != null)
                {
                    foreach (var comment in comments)
                    {
                        await ManagerDB.SaveCommentAsync(comment);
                    }
                }
            }
            catch (JsonException ex)
            {
                Console.WriteLine($"Error deserializing JSON: {ex.Message}");
                Console.WriteLine($"JSON: {jsonString}");
                throw;
            }

            return "Comments added to the database";
        }
    }
}
