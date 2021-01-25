<template>
  <li class="shopcart" v-on:click="mark()"><a class="cartbox_active" href="#">
                        <i class="fa fa-bell-o text-white"></i>
                        <span class="product_qun" v-if="unreadCount > 0">{{unreadCount}}</span></a>
                        <!-- Start Shopping Cart -->
                        <div class="block-minicart minicart__active">
                            <div class="minicart-content-wrapper">
                                <div class="micart__close">
                                    <span>close</span>
                                </div>
                                <div class="single__items">
                                    <div class="miniproduct">
                                        <div class="item01 d-flex mb-2" v-for="notify in unread" :key="notify.id">
                                            <div class="thumb">
                                                <a href="product-details.html"><img src="/frontend/images/product/sm-img/1.jpg" alt="product images"></a>
                                            </div>
                                            <div class="content">
                                                <h6><a href="product-details.html" style="font-size: 13px">{{ notify.data.name }}</a></h6>
                                                <span class="prize text-muted" style="font-size: 11px; display: block; margin-top: -10px;">{{notify.data.created_at}}</span>
                                            </div>
                                        </div>
                                        <div class="item01 d-flex mb-2" v-for="readshow in read" :key="readshow.id">
                                            <div class="thumb">
                                                <a href="product-details.html"><img src="/frontend/images/product/sm-img/1.jpg" alt="product images"></a>
                                            </div>
                                            <div class="content">
                                                <h6><a href="product-details.html" style="font-size: 13px">{{ readshow.data.name }}</a></h6>
                                                <span class="prize text-muted" style="font-size: 11px; display: block; margin-top: -10px;">{{readshow.data.created_at}}</span>
                                            </div>
                                        </div>
                                        <div class="item01 d-flex mb-2" id="nofound" v-if="readCount == 0">
                                            <div class="content">
                                                <h6 class="text-center mt-2">No Found Notifications</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Shopping Cart -->
                    </li>
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
          if(this.unreadCount != 0){
            $("#nofound").remove();
          }
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
