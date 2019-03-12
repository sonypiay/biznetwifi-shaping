<template>
  <div>
    <div class="uk-margin-top uk-container">
      <h3 class="content-heading">Admin Roles</h3>
      <div class="uk-card uk-card-body uk-card-small content-data">
        <div class="uk-grid-small" uk-grid>
          <div class="uk-width-1-6@xl uk-width-1-6@l uk-width-1-3@m uk-width-1-1@s">
            <button class="uk-width-1-1 uk-button uk-button-default form-content-button" name="button">Add New Roles</button>
          </div>
          <div class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-3@m uk-width-1-1@s">
            <select class="uk-select form-content-select" v-model="forms.selectedrows" @change="getAdminRoles( pagination.path + '?page=' + pagination.current )">
              <option value="10">10 rows</option>
              <option value="20">20 rows</option>
              <option value="50">50 rows</option>
              <option value="100">100 rows</option>
              <option value="200">200 rows</option>
              <option value="500">500 rows</option>
            </select>
          </div>
        </div>

        <div class="uk-margin table-overflow-content">
          <div v-if="isLoading === true" class="uk-text-center"> <span uk-spinner></span> </div>
          <div v-else-if="adminroles.total === 0">
            <div class="uk-alert-warning" uk-alert>No data are available...</div>
          </div>
          <div class="uk-overflow-auto" v-else>
            <div class="uk-height-medium">
              <table class="uk-table uk-table-small uk-table-middle uk-table-divider uk-table-hover table-data-content">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Last Updated</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="roles in adminroles.results">
                    <td>
                      <a class="uk-icon-button" uk-icon="pencil"></a>
                      <a class="uk-icon-button" uk-icon="trash"></a>
                    </td>
                    <td>{{ roles.username }}</td>
                    <td>{{ roles.fullname }}</td>
                    <td>{{ roles.email }}</td>
                    <td>
                      {{ formatDate( roles.created_at, 'YYYY/MM/DD HH:mm' ) }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['url'],
  data() {
    return {
      forms: {
        selectedrows: 10,
        keywords: '',
        username: '',
        password: '',
        email: '',
        fullname: '',
        error: false,
        submit: false
      },
      errors: {},
      errorMessage: '',
      adminroles: {
        total: 0,
        results: []
      },
      pagination: {
        current: 1,
        last_page: 1,
        path: '',
        next_url: '',
        prev_url: ''
      },
      isLoading: false
    }
  },
  methods: {
    formatDate(str, format) {
      var res = moment(str).locale('en').format(format);
      return res;
    },
    getAdminRoles( pages )
    {
      var url, param = '&keywords=' + this.forms.keywords + '&rows=' + this.forms.selectedrows;
      if( pages === undefined )
        url = this.url + 'admin/data_admin_roles?page=' + this.pagination.current + param;
      else
        url = pages + param;

      this.isLoading = true;
      axios({
        method: 'get',
        url: url,
        headers: { 'Content-Type': 'application/json' }
      }).then( res => {
        let result = res.data;
        this.adminroles.total = result.total;
        this.adminroles.results = result.data;
        this.pagination = {
          current: result.current_page,
          last_page: result.last_page,
          path: result.path,
          next_url: result.next_page_url,
          prev_url: result.prev_page_url
        };
        this.isLoading = false;
      }).catch( err => {
        console.log( err.response.statusText );
        this.isLoading = false;
      });
    }
  },
  mounted() {
    this.getAdminRoles();
  }
}
</script>
