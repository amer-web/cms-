<template>
  <div class="dropdown nav-item main-header-notification" v-on:click="mark()">
    <a class="new nav-link" href="#"
      ><svg
        xmlns="http://www.w3.org/2000/svg"
        class="header-icon-svgs feather feather-bell"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round">
        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg
      ><span class="pulse lolo" v-if="unreadCount > 0"></span></a>
    <div class="dropdown-menu">
      <div class="menu-header-content bg-primary text-right">
        <div class="d-flex">
          <h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">
            Notifications
          </h6>
          <span
            class="badge badge-pill badge-warning mr-auto my-auto float-left">
            Mark All Read</span>
        </div>
        <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12">
          You have 4 unread Notifications
        </p>
      </div>
      <div class="main-notification-list Notification-scroll">
        <a class="d-flex p-3 border-bottom" href="#" v-for="notify in unread" :key="notify.id">
          <div class="notifyimg bg-pink" style="width:40px;height:40px">
            <i class="fa fa-comment text-white"></i>
          </div>
          <div class="mr-3">
            <h5 class="notification-label mb-1 ml-1">{{notify.data.name }}</h5>
            <div class="notification-subtext ml-1">{{notify.data.created_at }}</div>
          </div>
        </a>

        <a class="d-flex p-3 border-bottom" href="#" v-for="readshow in read" :key="readshow.id">
          <div class="notifyimg bg-pink" style="width:40px;height:40px">
            <i class="fa fa-comment text-white"></i>
          </div>
          <div class="mr-3">
            <h5 class="notification-label mb-1 ml-1">{{readshow.data.name }}</h5>
            <div class="notification-subtext ml-1">{{readshow.data.created_at}}</div>
          </div>
        </a>

      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      read: {},
      unread: {},
      readCount: 0,
      unreadCount: 0,
    };
  },
  created: function () {
    this.getNotification();

    let userId = $("meta[name='userId']").attr("content");
    Echo.private("App.User." + userId).notification((notification) => {
      this.unread.unshift(notification);
      this.unreadCount++;
      $("#nofound").remove();
      $('.lolo').addClass('pulse');
    });
  },
  methods: {
    getNotification() {
      axios
        .get("/user/notifications/get")
        .then((res) => {
          this.read = res.data.read;
          this.readCount = res.data.readcount;
          this.unread = res.data.unread;
          this.unreadCount = res.data.unreadcount;
        })
        .catch((error) => Exception.handel(error));
    },
    mark() {
      axios.get("/notifications/markAsRead");
      this.unreadCount = 0;
    },
  },
};
</script>
