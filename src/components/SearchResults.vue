<script>
export default {
  name: 'search-results',
  props: {
    results: Object,
  },
  data() {
    return {
      h: this.$createElement,
    }
  },
  render() {
    if (!this.results) return

    const items = this.results.items.map((result) => {
      const tdLink = this.h('td', {},
        [
          this.h('a',
          {
            attrs: {
              href: result.link,
              target: '_blank',
              rel:'noopener noreferrer',
            },
          },
          [result.title])
        ])
      const tdDesc = this.h('td', 
        {
          class: ['desc'],
        },
        [
          this.h('p', {}, [result.snippet])
        ])
      return this.h('tr', { class: ['search-result'] }, [tdLink, tdDesc])
    })
    return this.h('table', {}, [...items]);
  }
}
</script>
<style scoped>

table {
  width: 100%;
  text-align: left;
}

.desc {
  padding-left: 2em;
}

</style>