<script>
export default {
  name: "Channel",
  components: {},
  data() {
    return {
      jsonData: [],
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      fetch("http://localhost/exam/exam-vue/youtube_channel_json.php")
        .then((response) => response.json())
        .then((data) => {
          this.jsonData = data.youtube_channels;
          
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    },
  },
};
</script>

<template>
  <div v-for="data in jsonData" class="container">
    <div class="profile">
      <img :src="data._picture" alt="" />
    </div>
    <div class="content">
      <h1>{{ data._name }}</h1>
      <p class="description">{{ data._description }}</p>
    </div>
  </div>
  <!-- <div v-else>Loading...</div> -->
</template>

<style scoped>
h1 {
  line-height: 2;
}

.container {
  display: flex;
  align-items: center;
}
.content {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  margin-top: 3%;
  margin-left: 2%;
  text-align: left;
}
.profile {
  width: 290px;
  height: 100px;
  border-radius: 50%;
  overflow: hidden;
  margin-right: 10px;
}

.profile img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Responsive Styles */
@media (max-width: 767px) {
  .profile {
    width: 150px;
    height: 50px;
  }
}

.description {
  margin-top: auto;
  font-size: 14px;
}
</style>
