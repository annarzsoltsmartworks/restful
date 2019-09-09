<template>
  <div>
    <router-link :to="{ name: 'home' }">Home</router-link>
    <router-link :to="{ name: 'books' }">Books</router-link>
    <articles-list></articles-list>
  </div>
</template>
