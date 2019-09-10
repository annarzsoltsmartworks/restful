<template>
  <div>
    <router-link :to="{ name: 'home' }">Home</router-link>
    <router-link :to="{ name: 'books' }">Books</router-link>

    <div class="container">
      <books-list></books-list>
    </div>

  </div>
</template>
