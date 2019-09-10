<template>
  <div>
    <h3 class="my-4">Books</h3>
    <button class="btn btn-primary mb-4" @click="newBook()">New Book</button>
    <template v-if="showForm">
      <form @submit.prevent="addBook"  class="mb-4">
        <div class="form-group">
          <input v-model="book.title" class="form-control" type="text" placeholder="title">
        </div>
        <div class="form-group">
          <input v-model="book.author" class="form-control" type="text" placeholder="author">
        </div>
        <div class="form-group">
          <input v-model="book.release_year" class="form-control" type="text" placeholder="release_year">
        </div>
        <div class="form-group">
          <textarea v-model="book.description" class="form-control" type="text" placeholder="description"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Mentés</button>
      </form>
    </template>

    <div v-for="book in books" v-bind:key="book.id" class="card mb-2">
      <div class="card-body">
        <h5>{{book.title}}</h5>
        <p><i>{{book.author}}</i> <b>({{book.release_year}})</b></p>
        <p>{{book.description}}</p>
      </div>
      <div class="card-footer text-right">
        <button class="btn btn-warning" @click="editBook(book)">Edit</button>
        <button class="btn btn-danger" @click="deleteBooks(book.id)">Delete</button>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data: function () {
      return {

        url: '/api/book',
        books: [],
        book: {
          id: '',
          title: '',
          author: '',
          release_year: '',
          description: ''
        },
        edit: false,
        showForm: false
      }
    },
    created: function () {
      this.fetchAllBooks()
    },
    methods: {
      fetchAllBooks: function () {

        let page_url = page_url || this.url

        let vm = this

        fetch(page_url)
          .then(res => res.json())
          .then(res => {
            vm.books = res.data;
          })
          .catch(err => console.log(err))
      },
      deleteBooks: function (id) {
        let vm = this

        fetch(vm.url + '/' + id, {method: 'delete'})
          .then(res => res.json())
          .then(res => {
            vm.fetchAllBooks()
          })
          .catch(err => console.log(err))
      },
      editBook: function (book) {
        this.edit = true;
        this.showForm = !this.showForm;
        this.book.id = book.id;
        this.book.title = book.title;
        this.book.author = book.author;
        this.book.release_year = book.release_year;
        this.book.description = book.description;
      },
      addBook: function () {

        let vm = this;

        if (vm.edit === true) {
          fetch(vm.url + '/' + vm.book.id, {
            method: 'put',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(this.book)
          })
            .then(res => res.json())
            .then(res => {
              vm.book = {
                id: '',
                title: '',
                author: '',
                release_year: '',
                description: ''
              }
              vm.showForm = false
              vm.fetchAllBooks()
            })
            .catch(err => console.log(err))
        } else {
          fetch(vm.url, {
            method: 'post',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(this.book)
          })
            .then(res => res.json())
            .then(res => {
              vm.book = {
                id: '',
                title: '',
                author: '',
                release_year: '',
                description: ''
              }
              vm.showForm = false
              vm.fetchAllBooks()
            })
            .catch(err => console.log(err))
        }
      },
      newBook: function () {
        this.edit = false;
        this.showForm = !this.showForm;
      }
    }
  }
</script>
