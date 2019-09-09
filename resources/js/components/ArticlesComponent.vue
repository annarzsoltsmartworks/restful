<template>
  <div>
    <h2 class="mb-5">Articles</h2>
    <button @click="newArticle" class="btn btn-primary mb-5">New Article</button>
    <template v-if="showForm" >
      <h5 class="mb-3">New</h5>
      <form @submit.prevent="addArticle" class="mb-5">
        <div class="form-group">
          <input class="form-control" type="text" placeholder="Title" v-model="article.title">
        </div>
        <div class="form-group">
          <textarea class="form-control" type="text" placeholder="Body" v-model="article.body"></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Save</button>
      </form>
    </template>

    <div class="card mb-2" v-for="article in articles" v-bind:key="article.id">
      <div class="card-body">
        <h3>{{ article.title }}</h3>
        <p>{{ article.body }}</p>
      </div>
      <div class="card-footer text-right">
        <button @click="editArticle(article)" class="btn btn-warning">Edit</button>
        <button @click="deleteArticle(article.id)" class="btn btn-danger">Delete</button>
      </div>
    </div>

    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item" :class="[{disabled: !pagination.prev_page_url}]">
          <a class="page-link" @click="fetchArticles(pagination.prev_page_url)">Previous</a>
        </li>
        <li v-for="i in pagination.last_page" :class="[{active: pagination.current_page === i}]" class="page-item">
          <a class="page-link" @click="fetchArticles(pagination.path + '?page=' + i)">
            {{i}}
          </a>
        </li>
        <li class="page-item" :class="[{disabled: !pagination.next_page_url}]">
          <a class="page-link" @click="fetchArticles(pagination.next_page_url)">Next</a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        articles: [],
        article: {
          id: "",
          title: "",
          body: ""
        },
        article_id: '',
        pagination: {},
        edit: false,
        showForm: false
      }
    },
    created() {
      this.fetchArticles();
    },
    methods: {
      fetchArticles(page_url) {
        let vm = this;

        page_url = page_url || '/api/article'

        fetch(page_url)
          .then(res => res.json())
          .then(res => {
            console.log(res)
            this.articles = res.data
            vm.makePagination(res.meta, res.links)
          })
          .catch(err => console.log(err))
      },
      makePagination(meta, links) {
        let pagination = {
          current_page: meta.current_page,
          last_page: meta.last_page,
          next_page_url: links.next,
          prev_page_url: links.prev,
          path: meta.path
        }

        this.pagination = pagination
      },
      deleteArticle(id) {
        let vm = this;

        if (confirm('Are you sure?')) {
          fetch(`api/article/${id}`, {method: 'delete'})
            .then(res => res.json())
            .then(res => {
              console.log(res)
              vm.fetchArticles()
            })
            .catch(err => console.log(err))
        }
      },
      addArticle() {

        let vm = this;

        if (this.edit === false) {
          // Add
          fetch('api/article', {
            method: 'post',
            body: JSON.stringify(this.article),
            headers: {
              'content-type': 'application/json'
            }
          })
            .then(res => res.json())
            .then(res => {
              vm.article.title = '';
              vm.article.body = '';
              vm.showForm = false;
              vm.fetchArticles()
            })
            .catch(err => console.log(err))

        } else {
          fetch('api/article/' + this.article.id, {
            method: 'put',
            body: JSON.stringify(this.article),
            headers: {
              'content-type': 'application/json'
            }
          })
            .then(res => res.json())
            .then(res => {
              vm.article.title = '';
              vm.article.body = '';
              vm.showForm = false;
              vm.fetchArticles()
            })
            .catch(err => console.log(err))
        }
      },
      editArticle(article) {
        this.edit = true;
        this.showForm = !this.showForm;
        this.article.id = article.id;
        this.article.title = article.title;
        this.article.body = article.body;

      },
      newArticle(){
        this.showForm = !this.showForm;
      }
    }
  }
</script>
