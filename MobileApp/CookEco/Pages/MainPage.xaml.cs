﻿using System;
using System.Collections.ObjectModel;
using System.Threading.Tasks;
using Microsoft.Maui.Controls;
using CookEco.Models;
using CookEco.Services;

namespace CookEco
{
    public partial class MainPage : ContentPage
    {
        public ObservableCollection<Recipe> Recipes { get; set; }
        private FetchUserRecipe fetchUserRecipe;

        public MainPage()
        {
            InitializeComponent();
            Recipes = new ObservableCollection<Recipe>();
            RecipeListView.ItemsSource = Recipes;
            fetchUserRecipe = new FetchUserRecipe();
            LoadRecipes();
        }

        private async void LoadRecipes()
        {
            await ManagerDB.Init();
            var recipes = await ManagerDB.GetRecipesAsync();
            foreach (var recipe in recipes)
            {
                Recipes.Add(recipe);
            }
            await FetchAndDisplayRecipesFromAPI();
        }

        private async Task FetchAndDisplayRecipesFromAPI()
        {
            await fetchUserRecipe.AddAllRecipes();
            await RefreshRecipes();
        }

        protected override async void OnAppearing()
        {
            base.OnAppearing();
            await RefreshRecipes();
        }

        private async Task RefreshRecipes()
        {
            await ManagerDB.Init();
            var newRecipes = await ManagerDB.GetRecipesAsync();
            Recipes.Clear();
            foreach (var recipe in newRecipes)
            {
                Recipes.Add(recipe);
            }
        }
        private async void OnCreateRecipeClicked(object sender, EventArgs e)
        {
            var createRecipePage = new CreateRecipePage();
            createRecipePage.SetRecipesCollection(Recipes);
            await Navigation.PushAsync(createRecipePage);
        }
    }
}