<template>
  <div>
    <div class="push-notification" :class="{message : notification}">
      <i class="fas fa-bell"></i>
      <span>{{ userSent }} messaged you</span>
    </div>
    <!-- <div class="notification-menu">
            <div class="notification-item" v-for="notification in notificationsData" :key="notification.id">
                <p v-text="notification.body" v-if="!notification.seen"></p>
            </div>
    </div>-->
    <div class="container">
      <div class="row">
        <div class="wel-msg col-lg-12">
          <h5 class="display-4">welcome , {{username}} choose a user to begin chatting have fun!!!</h5>
        </div>
        <div class="loader" v-if="loader"></div>
        <table class="table table-light striped bordered" :class="{'d-none' : loader}">
          <thead class="thead-light">
            <tr>
              <th>#</th>
              <th>username</th>
              <th>action</th>
            </tr>
          </thead>
          <tbody>
            <user v-for="user in userData" :key="user.id" :username="user.username" :token="token" />
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
const axios = require("axios");
const Pusher = require("pusher-js");
import user from "./user";
export default {
  name: "home",
  props: ["username", "userid", "token"],
  mounted: function() {
    this.liveUpdate();
    this.recievedANewMessage();
  },
  created() {
    this.getUsers();
    this.notifications();
  },
  data: function() {
    return {
      userData: [],
      loader: true,
      userSent: "",
      notification: false,
      counter: 1,
      notificationsData: []
    };
  },
  methods: {
    getUsers() {
      let $this = this;
      axios
        .post("/api/activeusers", {
          id: this.userid
        })
        .then(function(response) {
          $this.loader = false;
          $this.userData = response.data;
        })
        .catch(err => console.error(err));
    },
    liveUpdate() {
      const $this = this;

      Pusher.logToConsole = true;

      var pusher = new Pusher("90ada675880388af9865", {
        cluster: "eu",
        forceTLS: true
      });

      var channel = pusher.subscribe("status");

      console.log("listening for online users update");

      channel.bind("status-event", function(data) {
        axios
          .post("/api/activeusers", {
            id: $this.userid
          })
          .then(response => {
            $this.userData = response.data;
          })
          .catch(err => console.error(err));
      });
    },
    recievedANewMessage() {
      const $this = this;

      Pusher.logToConsole = true;

      var pusher = new Pusher("90ada675880388af9865", {
        cluster: "eu",
        forceTLS: true
      });

      var channel = pusher.subscribe("push-not-" + this.userid);

      console.log("listening for new message");
      channel.bind("event", function(data) {
        console.log(data);
      });
    },
    notifications() {
      axios
        .post("/getnotifications", {
          id: this.userid
        })
        .then(res => {
          this.notificationsData = res.data;
        })
        .catch(err => console.error(err));
    }
  },
  components: {
    user
  }
};
</script>
<style lang="scss" scoped>
.message {
  right: 10px !important;
  transition: 1s ease-in-out;
}
.notification-menu {
  position: absolute;
  right: 50px;
  top: 80px;
  background: #eee;
  border-radius: 5px;
  box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.4);
  width: 200px;
  height: 200px;
  z-index: 9999;
  // display: none;
  .notification-item {
    border-bottom: 2px solid white;
    margin-top: 10px;
    text-align: center;
  }
}
</style>