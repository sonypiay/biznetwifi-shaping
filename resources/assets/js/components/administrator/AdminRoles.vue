<template>
  <div>
    <div id="modal" uk-modal>
      <div class="uk-modal-dialog uk-modal-body content-data-modal">
        <a class="uk-modal-close-default" uk-close></a>
        <h3>
          <span v-if="forms.edit">Edit Admin Roles</span>
          <span v-else>Add Admin Roles</span>
        </h3>
        <form class="uk-form-stacked" @submit.prevent="onAddOrUpdateRole()">
          <div v-if="errorMessage" class="uk-alert-danger" uk-alert>{{ errorMessage }}</div>
          <div class="uk-margin">
            <label class="uk-form-label">Fullname</label>
            <div class="uk-form-controls">
              <input type="text" placeholder="Enter fullname" class="uk-width-1-1 uk-input form-modal-input" v-model="forms.fullname">
            </div>
            <div class="uk-text-danger uk-text-small" v-if="errors.fullname">{{ errors.fullname }}</div>
          </div>
          <div class="uk-margin">
            <label class="uk-form-label">Username</label>
            <div class="uk-form-controls">
              <input type="text" placeholder="Enter username" class="uk-width-1-1 uk-input form-modal-input" v-model="forms.username">
            </div>
            <div class="uk-text-danger uk-text-small" v-if="errors.username">{{ errors.username }}</div>
          </div>
          <div class="uk-margin">
            <label class="uk-form-label">Email</label>
            <div class="uk-form-controls">
              <input type="email" placeholder="Enter email" class="uk-width-1-1 uk-input form-modal-input" v-model="forms.email">
            </div>
            <div class="uk-text-danger uk-text-small" v-if="errors.email">{{ errors.email }}</div>
          </div>
          <div class="uk-margin">
            <label class="uk-form-label">Password</label>
            <div class="uk-form-controls">
              <input type="password" placeholder="Enter password" class="uk-width-1-1 uk-input form-modal-input" v-model="forms.password">
            </div>
            <div class="uk-text-danger uk-text-small" v-if="errors.password">{{ errors.password }}</div>
          </div>
          <div class="uk-margin">
            <label class="uk-form-label">Privilege</label>
            <select class="uk-width-1-1 uk-select form-modal-select" v-model="forms.privilege">
              <option value="full">Full Access</option>
              <option value="write">Write</option>
              <option value="read">Read Only</option>
            </select>
          </div>
          <div class="uk-margin">
            <button class="uk-button uk-button-default form-modal-button" v-html="forms.submit"></button>
          </div>
        </form>
      </div>
    </div>

    <div class="uk-margin-top uk-container">
      <h3 class="content-heading">Admin Roles</h3>
      <div class="uk-card uk-card-body uk-card-small content-data">
        <div class="uk-grid-small" uk-grid>
          <div class="uk-width-1-6@xl uk-width-1-6@l uk-width-1-3@m uk-width-1-1@s">
            <button @click="modalAddOrUpdate()" class="uk-width-1-1 uk-button uk-button-default form-content-button" name="button">Add New Roles</button>
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

        <div class="uk-card uk-card-default uk-card-body uk-margin table-overflow-content">
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
                    <th>Privileges</th>
                    <th>Last Updated</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="roles in adminroles.results">
                    <td>
                      <a @click="modalAddOrUpdate( roles )" class="uk-icon-button" uk-icon="pencil"></a>
                      <a @click="onDeleteAdminRole( roles.userid, roles.username )" class="uk-icon-button" uk-icon="trash"></a>
                    </td>
                    <td>{{ roles.username }}</td>
                    <td>{{ roles.fullname }}</td>
                    <td>{{ roles.email }}</td>
                    <td>
                      <span v-if="roles.privilege === 'full'">Full Access</span>
                      <span v-else-if="roles.privilege === 'write'">Read and Write</span>
                      <span v-else>Read Only</span>
                    </td>
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
        userid: '',
        username: '',
        password: '',
        email: '',
        fullname: '',
        privilege: 'full',
        error: false,
        submit: 'Add',
        edit: false
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
    formatDate(str, format)
    {
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
        console.log( this.forms );
      }).catch( err => {
        console.log( err.response.statusText );
        this.isLoading = false;
      });
    },
    modalAddOrUpdate( role )
    {
      if( role === undefined )
      {
        this.forms.userid = '';
        this.forms.username = '';
        this.forms.password = '';
        this.forms.email = '';
        this.forms.fullname = '';
        this.forms.privilege = 'full';
        this.forms.submit = 'Add';
      }
      else
      {
        this.forms.userid = role.userid;
        this.forms.username = role.username;
        this.forms.password = '';
        this.forms.email = role.email;
        this.forms.fullname = role.fullname;
        this.forms.privilege = role.privilege;
        this.forms.submit = 'Edit';
        this.forms.edit = true;
      }
      this.forms.error = '';
      this.errors = {};
      this.errorMessage = '';
      UIkit.modal('#modal').show();
    },
    onAddOrUpdateRole()
    {
      this.errors = {};
      this.errorMessage = '';
      if( this.forms.username === '' )
      {
        this.errors.username = 'Username is required.';
        this.forms.error = true;
      }
      if( this.forms.email === '' )
      {
        this.errors.email = 'Email is required.';
        this.forms.error = true;
      }

      if( this.forms.edit === false )
      {
        if( this.forms.password === '' )
        {
          this.errors.password = 'Password is required';
          this.forms.error = true;
        }
        else
        {
          if( this.forms.password.length < 8 )
          {
            this.errors.password = 'Password must be at least 8 character(s)';
            this.forms.error = true;
          }
        }
      }
      else
      {
        if( this.forms.password !== '' )
        {
          if( this.forms.password.length < 8 )
          {
            this.errors.password = 'Password must be at least 8 character(s)';
            this.forms.error = true;
          }
        }
      }


      if( this.forms.error === true )
      {
        this.forms.error = false;
        return false;
      }

      var method, url;
      if( this.forms.edit === true )
      {
        method = 'put';
        url = this.url + 'admin/update/admin_roles/' + this.forms.userid;
      }
      else
      {
        method = 'post';
        url = this.url + 'admin/create/admin_roles';
      }
      this.forms.submit = '<span uk-spinner><span>';
      axios({
        method: method,
        url: url,
        params: {
          fullname: this.forms.fullname,
          username: this.forms.username,
          password: this.forms.password,
          email: this.forms.email,
          privilege: this.forms.privilege
        },
        headers: { 'Content-Type': 'application/json' }
      }).then( res => {
        swal({
          title: 'Success',
          text: res.data.statusText,
          icon: 'success'
        });
        this.getAdminRoles();
        setTimeout(function(){
          UIkit.modal('#modal').hide();
        }, 2000);
      }).catch( err => {
        if( err.response.status === 409 )
        {
          swal({
            title: 'Whoops',
            text: err.response.data.statusText,
            icon: 'warning',
            dangerMode: true
          });
        }
        else
        {
          swal({
            title: 'Whoops',
            text: err.response.statusText,
            icon: 'error',
            dangerMode: true
          });
        }
        if( this.forms.edit === true )
          this.forms.submit = 'Edit';
        else
          this.forms.submit = 'Add';
      });
    },
    onDeleteAdminRole(userid, username)
    {
      swal({
        title: 'Are you sure?',
        text: username + ' will be delete permanently.',
        icon: 'warning',
        dangerMode: true,
        buttons: {
          cancel: 'No',
          confirm: {
            text: 'Sure',
            value: true
          }
        }
      }).then( val => {
        if( val )
        {
          axios({
            method: 'delete',
            url: this.url + 'admin/delete/admin_roles/' + userid,
            headers: { 'Content-Type': 'application/json' }
          }).then( res => {
            swal({
              title: 'Success',
              text: res.data.statusText,
              icon: 'success'
            });
            this.getAdminRoles();
          }).catch( err => {
            swal({
              title: 'Whoops',
              text: err.response.statusText,
              icon: 'warning',
              dangerMode: true
            })
          });
        }
      });
    }
  },
  mounted() {
    this.getAdminRoles();
  }
}
</script>
