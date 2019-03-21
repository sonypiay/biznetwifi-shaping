<template>
  <div>
    <div class="uk-margin-top">
      <h3 class="content-heading">Client as Visitor</h3>
      <div class="uk-card uk-card-body uk-card-default content-data">
        <div class="uk-grid-small" uk-grid>
          <div class="uk-width-1-6@xl uk-width-1-6@l uk-width-1-3@m uk-width-1-1@s">
            <select class="uk-select form-content-select" v-model="forms.selectedrows" @change="getClientAsSubscriber( pagination.path + '?page=1' )">
              <option value="10">10 rows</option>
              <option value="20">20 rows</option>
              <option value="50">50 rows</option>
              <option value="100">100 rows</option>
              <option value="200">200 rows</option>
              <option value="500">500 rows</option>
            </select>
          </div>
          <div class="uk-width-1-6@xl uk-width-1-6@l uk-width-1-3@m uk-width-1-1@s">
            <select class="uk-select form-content-select" v-model="forms.filterap" @change="getClientAsSubscriber( pagination.path + '?page=1' )">
              <option value="all">All Access Point</option>
              <option value="ruckus">Ruckus Wireless</option>
              <option value="mkt">Mikrotik</option>
            </select>
          </div>
          <div class="uk-width-1-6@xl uk-width-1-6@l uk-width-1-3@m uk-width-1-1@s">
            <select class="uk-select form-content-select" v-model="forms.filterdevice" @change="getClientAsSubscriber( pagination.path + '?page=1' )">
              <option value="all">All Devices</option>
              <option value="Windows">Windows</option>
              <option value="Linux">Linux</option>
              <option value="Android">Android</option>
              <option value="iOS">iOS</option>
              <option value="Mac OS">Mac OS</option>
            </select>
          </div>
          <div class="uk-width-1-6@xl uk-width-1-6@l uk-width-1-3@m uk-width-1-1@s">
            <div class="uk-width-1-1 uk-inline">
              <button class="uk-width-1-1 uk-button uk-button-default form-content-button" type="button">
                {{ forms.filterdate.text }} <span uk-icon="chevron-down"></span>
              </button>
              <div class="form-content-dropdown" uk-dropdown="mode: click">
                <ul class="uk-nav uk-dropdown-nav">
                  <li>
                    <a v-if="forms.filterdate.value == 'today'" class="form-content-dropdown-active" @click="onFilteringDate('Today', 'today')">Today</a>
                    <a v-else @click="onFilteringDate('Today', 'today')">Today</a>
                  </li>
                  <li>
                    <a v-if="forms.filterdate.value == '7days'" class="form-content-dropdown-active" @click="onFilteringDate('Last 7 days', '7days')">Last 7 days</a>
                    <a v-else @click="onFilteringDate('Last 7 days ', '7days')">Last 7 days</a>
                  </li>
                  <li>
                    <a v-if="forms.filterdate.value == '28days'" class="form-content-dropdown-active" @click="onFilteringDate('Last 28 days', '28days')">Last 28 days</a>
                    <a v-else @click="onFilteringDate('Last 28 days', '28days')">Last 28 days</a>
                  </li>
                  <li>
                    <a v-if="forms.filterdate.value == '30days'" class="form-content-dropdown-active" @click="onFilteringDate('Last 30 days', '30days')">Last 30 days</a>
                    <a v-else @click="onFilteringDate('Last 30 days', '30days')">Last 30 days</a>
                  </li>
                  <li>
                    <a v-if="forms.filterdate.value == 'this_month'" class="form-content-dropdown-active" @click="onFilteringDate('This Month', 'this_month')">This Month</a>
                    <a v-else @click="onFilteringDate('This Month', 'this_month')">This Month</a>
                  </li>
                  <li>
                    <a v-if="forms.filterdate.value == 'last_month'" class="form-content-dropdown-active" @click="onFilteringDate('Last Month', 'last_month')">Last Month</a>
                    <a v-else @click="onFilteringDate('Last Month', 'last_month')">Last Month</a>
                  </li>
                  <li>
                    <a v-if="forms.filterdate.value == 'custom'" class="form-content-dropdown-active" @click="onFilteringDate('Custom Date', 'custom')">Custom Date</a>
                    <a v-else @click="onFilteringDate('Custom Date', 'custom')">Custom Date</a>
                  </li>
                </ul>
              </div>
            </div>
            <!--<v-date-picker :formats="datepicker.formats" mode="range" v-model="forms.datepicker" :select-attribute="datepicker.attributes" :input-props="datepicker.props" :theme-styles="datepicker.themeStyles" show-caps></v-date-picker>-->
          </div>
          <div class="uk-width-expand">
            <div class="uk-width-1-1 uk-inline">
              <a @click="getClientAsSubscriber( pagination.path + '?page=1' )" class="uk-form-icon" uk-icon="search"></a>
              <input @keyup.enter="getClientAsSubscriber( pagination.path + '?page=1' )" type="search" placeholder="Search keywords..." class="uk-width-1-1 uk-input form-content-input" v-model="forms.keywords">
            </div>
          </div>
        </div>

        <div v-if="clientassubscriber.isLoading === true" class="uk-text-center uk-margin-top">
          <span uk-spinner></span> Loading data...
        </div>
        <div v-else-if="clientassubscriber.total === 0" class="uk-margin-top">
          <div class="uk-alert-warning" uk-alert>No record(s).</div>
        </div>
        <div v-else class="uk-margin-top uk-overflow-auto">
          <div class="uk-margin">
            <span class="uk-label">Clients: {{ clientassubscriber.total }}</span>
          </div>
          <table class="uk-table uk-table-small uk-table-middle uk-table-divider uk-table-hover table-data-content">
            <thead>
              <tr>
                <th>Mac Address</th>
                <th>Operating System</th>
                <th>Access Point</th>
                <th>Last Connected</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="clients in clientassubscriber.results">
                <td>{{ clients.client_mac }}</td>
                <td>{{ clients.client_os }}</td>
                <td>
                  <span v-if="clients.ap == 'mkt'">Mikrotik</span>
                  <span v-else>Ruckus Wireless</span>
                </td>
                <td>{{ formatDate(clients.updated_at, 'MMM DD, YYYY HH:mm ') }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <ul class="uk-pagination content-data-pagination">
          <li>
            <a v-if="pagination.prev_url" @click="getClientAsSubscriber( pagination.prev_url )">
              <span uk-pagination-previous></span>
            </a>
            <a v-else>
              <span uk-pagination-previous></span>
            </a>
          </li>
          <li><a>Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
          <li>
            <a v-if="pagination.next_url" @click="getClientAsSubscriber( pagination.next_url )">
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
      forms: {
        datepicker: {
          start: '',
          end: ''
        },
        filterdate: {
          text: 'Today',
          value: 'today'
        },
        selectedrows: 10,
        filterdevice: 'all',
        filterap: 'all',
        keywords: ''
      },
      pagination: {
        current_page: 1,
        last_page: 1,
        prev_url: '',
        next_url: '',
        path: this.url + 'admin/clients/client_subscriber'
      },
      clientassubscriber: {
        total: 0,
        results: [],
        isLoading: false
      },
      datepicker: {
        props: {
          class: "uk-width-1-1 uk-input form-content-input",
          placeholder: "Enter date",
          readonly: true
        },
        attributes: {
          highlight: {
            backgroundColor: '#da068c',     // Red background
            borderColor: '#da068c',
            borderWidth: '2px',
            borderStyle: 'solid',
          }
        },
        themeStyles: {
          wrapper: {
            background: '#ffffff',
            color: '#ffffff',
            border: '0',
            borderRadius: '5px',
            boxShadow: '0 4px 8px 0 rgba(0, 0, 0, 0.14), 0 6px 20px 0 rgba(0, 0, 0, 0.13)'
          }
        },
        formats: {
          title: 'MMMM YYYY',
          weekdays: 'W',
          navMonths: 'MMM',
          input: ['L', 'YYYY-MM-DD', 'YYYY/MM/DD'], // Only for `v-date-picker`
          dayPopover: 'L', // Only for `v-date-picker`
          data: ['L', 'YYYY-MM-DD', 'YYYY/MM/DD'] // For attribute dates
        }
      }
    }
  },
  methods: {
    formatDate(str, format) {
      var res = moment(str).locale('id').format(format);
      return res;
    },
    onFilteringDate(str, val) {
      this.forms.filterdate = {
        text: str,
        value: val
      };
      this.getClientAsSubscriber( this.pagination.path + '?page=1' );
    },
    getClientAsSubscriber( pages )
    {
      var url, param;
      if( this.forms.datepicker.start === '' || this.forms.datepicker.start === undefined )
      {
        param = '&keywords=' + this.forms.keywords + '&filterdate=' + this.forms.filterdate.value + '&device=' + this.forms.filterdevice + '&ap=' + this.forms.filterap + '&rows=' + this.forms.selectedrows;
      }
      else
      {
        var startDate = this.formatDate( this.forms.datepicker.start, 'YYYY-MM-DD' );
        var endDate = this.formatDate( this.forms.datepicker.end, 'YYYY-MM-DD' );
        param = '&keywords=' + this.forms.keywords + '&startDate=' + startDate + '&endDate=' + endDate + '&device=' + this.forms.filterdevice + '&ap=' + this.forms.filterap + '&rows=' + this.forms.selectedrows;
      }

      if( pages === undefined )
        url = this.url + 'admin/clients/client_subscriber?page=' + this.pagination.current_page + param;
      else
        url = pages + param;

      this.clientassubscriber.isLoading = true;
      axios({
        method: 'get',
        url: url,
        headers: { 'Content-Type': 'application/json' }
      }).then( res => {
        let result = res.data;
        this.clientassubscriber.total = result.total;
        this.clientassubscriber.results = result.data;
        this.clientassubscriber.isLoading = false;
        this.pagination = {
          current_page: result.current_page,
          last_page: result.last_page,
          prev_url: result.prev_page_url,
          next_url: result.next_page_url,
          path: result.path
        };
      }).catch( err => {
        console.log( err.response.statusText );
      });
    }
  },
  mounted() {
    this.getClientAsSubscriber();
  }
}
</script>
