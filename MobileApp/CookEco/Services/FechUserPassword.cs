﻿using System;
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
            _http.BaseAddress = new Uri("http://192.168.0.29/");
        }

        public async Task<UsersResponse> GetUsersResponse()
        {
            try
            {
                var usersResponse = await _http.GetFromJsonAsync<UsersResponse>("/newAPI/CUBES3/index.php/users");
                if (usersResponse == null)
                {
                    Console.WriteLine("Error: usersResponse is null.");
                }
                else if (usersResponse.Records == null)
                {
                    Console.WriteLine("Error: usersResponse.Records is null.");
                }
                return usersResponse;
            }
            catch (HttpRequestException httpEx)
            {
                Console.WriteLine("HTTP Request Error: " + httpEx.Message);
                return null;
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error fetching users data: " + ex.Message);
                return null;
            }
        }

        public User MapUser(User user)
        {
            return new User
            {
                Id = user.Id,
                Username = user.Username,
                Password = user.Password
            };
        }
    }
}