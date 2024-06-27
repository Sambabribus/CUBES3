using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;
using System.Net.Http.Json;
using System.Threading.Tasks;
using CookEco.Models;

namespace CookEco.Services
{
    internal class FetchUserPassword
    {
        private readonly HttpClient _http;

        public FetchUserPassword()
        {
            _http = new HttpClient();
            _http.BaseAddress = new Uri("http://192.168.1.10");
        }

        public class UsersResponse
        {
            public List<User> Records { get; set; }
        }

        public async Task<UsersResponse> GetUsersResponse()
        {
            try
            {
                var usersJson = await _http.GetFromJsonAsync<UsersResponse>("/API/CUBES3/CUBES3-api/index.php/users");
                return usersJson;
            }
            catch (HttpRequestException ex)
            {
                Console.WriteLine($"HttpRequestException: {ex.Message}");
                throw new Exception("Failed to connect to server. Please check your network connection.");
            }
            catch (Exception ex)
            {
                Console.WriteLine($"Exception: {ex.Message}");
                throw new Exception("An error occurred. Please try again later.");
            }
        }
    }
}
