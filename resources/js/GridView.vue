<template>
  <div>
    <div class="summary" v-if="showPagination">Displaying @{{dataset.pagination.first}}-@{{dataset.pagination.last}} of @{{dataset.pagination.total}} results.</div>
    <table>
      <thead>
      <tr v-if="columns.length">
        <th v-for="column in columns" v-html="column.name"></th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <td :colspan="columns.length>0?columns.length:null" class="text-center">
          No data to display
        </td>
      </tr>
      </tbody>
      <caption v-if="showPagination">
        <ul class="pagination">
          <li v-for="link in dataset.pagination.links" :key="link.label" v-if="link.url"
              class="page-item" :class="{disabled: link.disabled, active: link.active}">
            <a class="page-link"
               href="#"
               @click.prevent="fetchData(link.url)"
               v-html="link.label"
            >
            </a>
          </li>
        </ul>
      </caption>
    </table>
  </div>
</template>
<script>
export default {
  props: {
    initialFilters: Object,
    sortBy: String,
    sortOrder: String,
    ajaxUpdate: Boolean,
    targetUrl: String,
    enablePagination: Boolean,
    dataset: {
      type: Object,
      default: function () {
        return {pagination: {total: 0}}
      }
    }
  },

  data() {
    return {
      filters: Object.assign({}, this.initialFilters),
      sortColumn: this.sortBy,
      sortDesc: this.sortOrder === 'DESC',
      useAjax: this.ajaxUpdate,
      filterTimeout: null,
      columns: []
    }
  },
  computed: {
    showPagination() {
      return this.enablePagination && this.dataset.pagination.total > 0
    }
  },
  methods: {
    filter(skipDelay = false) {

      if (skipDelay) {
        this.$nextTick(() => {
          this.sendForm();
        });
        return;
      }

      if (this.filterTimeout) {
        clearTimeout(this.filterTimeout);
      }

      this.filterTimeout = setTimeout(() => {
        this.sendForm();
      }, 1000);
    },

    sort(column) {
      this.sortColumn = column;
      this.sortDesc = !this.sortDesc;

      this.$nextTick(() => {
        this.sendForm();
      });
    },

    sendForm() {
      if (!this.useAjax) {
        this.$refs.gridForm.submit();
      } else {
        let formData = new FormData(this.$refs.gridForm);
        fetch(this.targetUrl, formData)
            .then(function (data) {
              this.dataset = data;
            })
      }

    }
  }
};
</script>
<style lang="scss">
.sort-asc, .sort-desc {
  display: inline-block;
  width: 0;
  height: 0;
  margin-bottom: 5px;

  &.sort-asc {
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-bottom: 5px solid #007bff;
  }

  &.sort-desc {
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 5px solid #007bff;
  }
}
</style>
