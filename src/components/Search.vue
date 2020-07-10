<template>
  <div class="search">
    <h1>Start to explore</h1>
    <div class="search-container">
      <form @submit.prevent class="controls">
        <input type="text" v-model="query" class="custom-input" placeholder="Input the search query"/>
        <button type="submit" class="custom-button" @click="search(1)">Search</button>
      </form>
    </div>
    <div class="spinner" v-if="loading"><span></span></div>
    <div class="no-results" v-if="!loading && !results">No results to show.</div>
    <div class="search-results" v-if="results">
      <search-results :results="results"/>
      <div>
        <span v-for="page in pageCount" :key="page" class="pages" @click="loadPage(page)">{{page}}</span>
      </div>
    </div>
  </div>
</template>
<script>
import SearchResults from './SearchResults.vue'

export default {
  name: 'search',
  components: {
    SearchResults,
  },
  data() {
    return {
      loading: false,
      query: '',
      results: null,
      pageCount: 0,
      loadedPages: [],
    }
  },
  methods: {
    search(startIndex) {
      this.loading = true
      this.results = null
      this.pageCount = 0

      if (startIndex == 1) this.loadedPages = []

      const json = {
        query: encodeURI(this.query),
        start: startIndex,
      }
      fetch('search.php',{
        method: 'POST',
        body: JSON.stringify(json),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        }
      })
      .then(response => response.json())
      .then((data) => {
        if (!data.items) {
          this.results = null
          return
        }
        this.results = data
        this.pageCount = 10
        this.loadedPages.push(data)
      })
      .finally(() => this.loading = false)
    },
    loadPage(page) {

      window.scrollTo(0,0)
      
      const found = this.loadedPages.filter(p => Math.floor((p.queries && p.queries.request[0].startIndex / 10) || p.page) === page - 1)
      
      if (found.length) {
        this.results = found[0]
        return
      }
      
      this.search((page - 1) * 10 + 1)
    }
  }
}
</script>
<style scoped>

.search {
  width: 100%;
  height: 100%;
  text-align: center;
}

h1 {
  margin-bottom: 100px;
}

.search-container, .search-results {
  padding: 0px 10%;
}

.controls {
  display: flex;
}

button {
  width: 200px;
  margin-left: 20px;
  box-shadow: none;
}

.pages {
  cursor: pointer;
  padding: 8px;  
}

.pages:hover {
  text-decoration: underline;
}

.spinner {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 50px;
  height: 50px;
  margin: 0 auto;
}

.spinner span {
  position: absolute;
  top: 0;
  right: 0;
  background: red;
  width: 25px;
  height: 25px;
  border: 2px solid black;
  border-radius: 50%;
  animation: blink 1s ease infinite;
}

@keyframes blink{
  0% {
    opacity: 1;
  }
  50% {
    opacity: .5;
    top: -50px;
    width: 50px;
    height: 50px;
  }
  100% {
    opacity: 1;
    width: 25px;
    height: 25px;
  }
}

.no-results {
  margin-top: 2em;
}
</style>