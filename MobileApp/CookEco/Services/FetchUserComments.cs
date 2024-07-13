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
            var commentsResponse = JsonSerializer.Deserialize<CommentsResponse>(jsonString);

            if (commentsResponse?.Records != null)
            {
                foreach (var comment in commentsResponse.Records)
                {
                    await ManagerDB.SaveCommentAsync(comment);
                }
            }

            return "Comments added to the database";
        }
    }
}