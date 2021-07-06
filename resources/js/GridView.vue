<script>
export default {
  props: {
    id: String,
    originFilters: Object,
    sortBy: String,
    sortOrder: String,
    ajaxUpdate: String,
    targetUrl: String,
  },

  data() {
    return {
      filters: Object.assign({}, this.originFilters),
      sortDesc: this.sortOrder === 'DESC',
      useAjax: this.ajaxUpdate === 'true' || parseInt(this.ajaxUpdate) === 1,
      sortColumn: this.sortBy,
      filterTimeout: null,
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
