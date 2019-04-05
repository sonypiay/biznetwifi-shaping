<template>
  <div>
    <div class="uk-margin-top">
      <h3 class="content-heading">Bandwidth Usage</h3>
      <div class="uk-margin uk-card content-data">
        <div class="uk-width-1-1 uk-inline">
          <button class="uk-button uk-button-default form-content-button" type="button">
            {{ bandwidth_summary.filterdate.text }} <span uk-icon="chevron-down"></span>
          </button>
          <div class="uk-width-2-3" uk-dropdown="mode: click; pos: right-center">
            <div class="uk-dropdown-grid uk-grid-small" uk-grid>
              <div class="uk-width-expand">
                <v-date-picker :formats="datepicker.formats" mode="range" :is-inline="true" v-model="datepicker.filterdate" :select-attribute="datepicker.attributes" :input-props="datepicker.props" :theme-styles="datepicker.themeStyles" show-caps is-double-paned></v-date-picker>
              </div>
              <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-width-1-3@s">
                <ul class="uk-nav uk-dropdown-nav nav-datepicker">
                  <li>
                    <a v-if="bandwidth_summary.filterdate.value === 'today'" class="nav-active" @click="onFilteringDate('Today', 'today')">Today</a>
                    <a v-else @click="onFilteringDate('Today', 'today')">Today</a>
                  </li>
                  <li>
                    <a v-if="bandwidth_summary.filterdate.value === 'yesterday'" class="nav-active" @click="onFilteringDate('Yesterday', 'yesterday')">Yesterday</a>
                    <a v-else @click="onFilteringDate('Yesterday', 'yesterday')">Yesterday</a>
                  </li>
                  <li>
                    <a v-if="bandwidth_summary.filterdate.value === '7days'" class="nav-active" @click="onFilteringDate('7 days ago', '7days')">7 days ago</a>
                    <a v-else @click="onFilteringDate('7 days ago', '7days')">7 days ago</a>
                  </li>
                  <li>
                    <a v-if="bandwidth_summary.filterdate.value === '14days'" class="nav-active" @click="onFilteringDate('14 days ago', '14days')">14 days ago</a>
                    <a v-else @click="onFilteringDate('14 days ago', '14days')">14 days ago</a>
                  </li>
                  <li>
                    <a v-if="bandwidth_summary.filterdate.value === '28days'" class="nav-active" @click="onFilteringDate('28 days ago', '28days')">28 days ago</a>
                    <a v-else @click="onFilteringDate('28 days ago', '28days')">28 days ago</a>
                  </li>
                </ul>
                <button class="uk-width-1-1 uk-button uk-button-default button-datepicker" @click="getSummaryBandwidthUsage()">Apply</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="uk-margin">
        <div class="uk-grid-small" uk-grid>
          <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-2@s">
            <div class="uk-card uk-card-body uk-card-default card-bandwidth">
              <div class="uk-card-title card-bandwidth-heading"></div>
            </div>
          </div>
          <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-2@s">
            <div class="uk-card uk-card-body uk-card-default card-bandwidth">

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
      datepicker: {
        filterdate: {
          start: new Date(),
          end: new Date()
        },
        props: {
          class: "uk-width-1-1 uk-input form-content-datepicker",
          placeholder: "Enter date",
          readonly: true
        },
        attributes: {

        },
        themeStyles: {},
        formats: {
          title: 'MMMM YYYY',
          weekdays: 'W',
          navMonths: 'MMM',
          input: ['L', 'YYYY-MM-DD', 'YYYY/MM/DD'], // Only for `v-date-picker`
          dayPopover: 'L', // Only for `v-date-picker`
          data: ['L', 'YYYY-MM-DD', 'YYYY/MM/DD'] // For attribute dates
        }
      },
      bandwidth_summary: {
        filterdate: {
          value: 'today',
          text: this.$root.formatDate( new Date(), 'MMM DD, YYYY' ),
          start: new Date(),
          end: new Date()
        },
        bandwidth: {
          total_usage: {
            upload: 0,
            download: 0
          },
          freehotspot: {
            total_usage: {
              upload: 0,
              download: 0
            }
          },
          subscriber: {
            total_usage: {
              upload: 0,
              download: 0
            }
          }
        }
      }
    }
  },
  methods: {
    onFilteringDate(str, val) {
      this.bandwidth_summary.filterdate.text = str;
      this.bandwidth_summary.filterdate.value = val;
      if( val === 'today' )
      {
        this.datepicker.filterdate.start = new Date();
        this.datepicker.filterdate.end = new Date();
        this.bandwidth_summary.filterdate.text = this.$root.formatDate( new Date(), 'MMM DD, YYYY' );
      }
      else if( this.bandwidth_summary.filterdate.value === 'yesterday' )
      {
        var dt = new Date();
        var yesterday = dt.setDate(dt.getDate() - 1);
        this.bandwidth_summary.filterdate.text = this.$root.formatDate( new Date( yesterday ), 'MMM DD, YYYY' );
        this.datepicker.filterdate.start = new Date( yesterday );
        this.datepicker.filterdate.end = new Date( yesterday );
      }
      else
      {
        var dt = new Date(), startDate = new Date(), endDate = new Date();
        var dateArr = [];
        if( val === '7days' )
        {
          startDate = dt.setDate( dt.getDate() - 7 );
          dt = new Date();
          endDate = dt.setDate( dt.getDate() - 1 );
        }
        else if( val === '14days' )
        {
          startDate = dt.setDate( dt.getDate() - 14 );
          dt = new Date();
          endDate = dt.setDate( dt.getDate() - 1 );
        }
        else
        {
          startDate = dt.setDate( dt.getDate() - 28 );
          dt = new Date();
          endDate = dt.setDate( dt.getDate() - 1 );
        }
        var startDate = new Date( startDate );
        var endDate = new Date( endDate );
        this.datepicker.filterdate = {
          start: startDate,
          end: endDate
        };
        this.bandwidth_summary.filterdate.text = this.$root.formatDate( startDate, 'MMM DD, YYYY' ) + ' - ' + this.$root.formatDate( endDate, 'MMM DD, YYYY' );
      }
    },
    getSummaryBandwidthUsage()
    {
      var startDate = this.$root.formatDate( this.datepicker.filterdate.start, 'YYYY-MM-DD' );
      var endDate = this.$root.formatDate( this.datepicker.filterdate.end, 'YYYY-MM-DD' );
      axios({
        method: 'get',
        url: this.url + 'admin/bandwidth/total_usage?startDate=' + startDate + '&endDate=' + endDate,
        headers: { 'Content-Type': 'application/json' }
      }).then( res => {
        let results = res.data;
        this.bandwidth_summary.bandwidth.freehotspot.total_usage = {
          upload: results.freehotspot.total_usage.upload,
          download: results.freehotspot.total_usage.download
        };
        this.bandwidth_summary.bandwidth.subscriber.total_usage = {
          upload: results.subscribers.total_usage.upload,
          download: results.subscribers.total_usage.download
        };
        this.bandwidth_summary.bandwidth.total_usage = {
          upload: results.total_usage.upload,
          download: results.total_usage.download
        };
        console.log( this.bandwidth_summary.bandwidth );
      }).catch( err => {
        console.log( err.response.statusText );
      });
    }
  },
  mounted() {
    this.getSummaryBandwidthUsage();
  }
}
</script>
