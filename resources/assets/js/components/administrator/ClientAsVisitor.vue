<template>
  <div>
    <div class="uk-margin-top">
      <h3 class="content-heading">Admin Activity</h3>
      <div class="uk-card uk-card-body uk-card-default content-data">
        <div class="uk-grid-small" uk-grid>
          <div class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-3@m uk-width-1-1@s">
            <select class="uk-select form-content-select" v-model="forms.selectedrows" @change="getLogActivity( pagination.path + '?page=1' )">
              <option value="10">10 rows</option>
              <option value="20">20 rows</option>
              <option value="50">50 rows</option>
              <option value="100">100 rows</option>
              <option value="200">200 rows</option>
              <option value="500">500 rows</option>
            </select>
          </div>
          <div class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-3@m uk-width-1-1@s">
            <select class="uk-select form-content-select" v-model="forms.filterdevice" @change="getLogActivity( pagination.path + '?page=1' )">
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
                    <a v-if="forms.filterdate.value == 'this_week'" class="form-content-dropdown-active" @click="onFilteringDate('This Week', 'this_week')">This Week</a>
                    <a v-else @click="onFilteringDate('This Week', 'this_week')">This Week</a>
                  </li>
                  <li>
                    <a v-if="forms.filterdate.value == 'last_week'" class="form-content-dropdown-active" @click="onFilteringDate('Last Week', 'last_week')">Last Week</a>
                    <a v-else @click="onFilteringDate('Last Week', 'last_week')">Last Week</a>
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
          <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-3@m uk-width-1-1@s">
            <div class="uk-width-1-1 uk-inline">
              <a @click="getClientAsVisitors()" class="uk-form-icon" uk-icon="search"></a>
              <input @keyup.enter="getClientAsVisitors()" type="search" placeholder="Search keywords..." class="uk-width-1-1 uk-input form-content-input" v-model="forms.keywords">
            </div>
          </div>
        </div>
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
          start: new Date(),
          end: new Date()
        },
        filterdate: {
          text: 'Today',
          value: 'today'
        },
        selectedrows: 10,
        filterdevice: 'all',
        keywords: ''
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
    },
    getClientAsVisitors()
    {
      var start_date = this.formatDate( this.forms.datepicker.start, 'YYYY-MM-DD' );
      var end_date = this.formatDate( this.forms.datepicker.end, 'YYYY-MM-DD' );
      var r = {
        start: start_date,
        end: end_date
      };
      console.log( r );
    }
  },
  mounted() {

  }
}
</script>
