<template>
  <div>
    <div class="uk-margin-top uk-container">
      <h3 class="content-heading">Admin Activity</h3>
      <div class="uk-card uk-card-body uk-card-small content-data">
        <div class="uk-grid-small" uk-grid>
          <div class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-3@m uk-width-1-1@s">
            <select class="uk-select form-content-select" v-model="forms.selectedrows" @change="getLogActivity( pagination.path + '?page=' + pagination.current )">
              <option value="10">10 rows</option>
              <option value="20">20 rows</option>
              <option value="50">50 rows</option>
              <option value="100">100 rows</option>
              <option value="200">200 rows</option>
              <option value="500">500 rows</option>
            </select>
          </div>
          <div class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-3@m uk-width-1-1@s">
            <select class="uk-select form-content-select" v-model="forms.filterdevice" @change="getLogActivity( pagination.path + '?page=' + pagination.current )">
              <option value="all">All Devices</option>
              <option value="Windows">Windows</option>
              <option value="Linux">Linux</option>
              <option value="Android">Android</option>
              <option value="iOS">iOS</option>
              <option value="Mac OS">Mac OS</option>
            </select>
          </div>
          <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-1@s">
            <div class="uk-width-1-1 uk-inline">
              <a @click="getLogActivity( pagination.path + '?page=' + pagination.current )" class="uk-form-icon" uk-icon="search"></a>
              <input @keyup.enter="getLogActivity( pagination.path + '?page=' + pagination.current )" type="text" placeholder="Search keywords..." v-model="forms.keywords" class="uk-width-1-1 uk-input form-content-input">
            </div>
          </div>
        </div>

        <div class="uk-margin table-overflow-content">
          <div class="uk-overflow-auto">
            <div class="uk-height-medium">
              <table class="uk-table uk-table-small uk-table-middle uk-table-divider uk-table-hover table-data-content">
                <thead>
                  <tr>
                    <th>Date and Time</th>
                    <th>Administrator</th>
                    <th>Source IP</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="logs in logs_activity.results">
                    <td>{{ formatDate( logs.created_at, 'YYYY/MM/DD HH:mm:ss' ) }}</td>
                    <td>{{ logs.log_username }}</td>
                    <td>{{ logs.log_ip }}</td>
                    <td>{{ logs.log_type }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <ul class="uk-pagination content-data-pagination">
          <li>
            <a v-if="pagination.prev_url" @click="getLogActivity( pagination.prev_url )">
              <span uk-pagination-previous></span>
            </a>
            <a v-else>
              <span uk-pagination-previous></span>
            </a>
          </li>
          <li><a>Page {{ pagination.current }} of {{ pagination.last_page }}</a></li>
          <li>
            <a v-if="pagination.next_url" @click="getLogActivity( pagination.next_url )">
              <span uk-pagination-next></span>
            </a>
            <a v-else>
              <span uk-pagination-next></span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import VCalendar from 'v-calendar';
import 'v-calendar/lib/v-calendar.min.css';
export default {
  props: ['url'],
  components: { VCalendar },
  data() {
    return {
      logs_activity: {
        total: 0,
        results: []
      },
      pagination: {
        current: 1,
        next_url: '',
        prev_url: '',
        path: '',
        last_page: ''
      },
      forms: {
        filterdevice: 'all',
        keywords: '',
        selectedrows: 10
      }
    }
  },
  methods: {
    formatDate(str, format) {
      var res = moment(str).locale('en').format(format);
      return res;
    },
    getLogActivity(pages)
    {
      var url, param = '&keywords=' + this.forms.keywords + '&rows=' + this.forms.selectedrows + '&device=' + this.forms.filterdevice;
      if( pages === undefined )
        url = this.url + 'admin/log_data_admin?page=' + this.pagination.current_page + param;
      else
        url = pages + param;

      axios({
        method: 'get',
        url: url,
        headers: { 'Content-Type': 'application/json' }
      }).then( res => {
        let result = res.data;
        this.logs_activity.total = result.total;
        this.logs_activity.results = result.data;
        this.pagination = {
          current: result.current_page,
          next_url: result.next_page_url,
          prev_url: result.prev_page_url,
          path: result.path,
          last_page: result.last_page
        };
      }).catch( err => {
        console.log( err.response.statusText );
      });
    }
  },
  mounted() {
    this.getLogActivity();
  }
}
</script>
