<script>
export default {
  name: "Videos",
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
      fetch("http://localhost/exam/exam-vue/src/components/youtube_channel_json.php")
        .then((response) => response.json())
        .then((data) => {
          this.jsonData = data.youtube_channel_videos;
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    },
  },
};
</script>

<template>
  <div class="container">
    <div class="content">
      <h2>Videos</h2>
      <hr />
    </div>
  </div>
  <div class="videos-container">
    <div v-for="data in jsonData" :key="data.id" class="video-card">
      <div class="thumbnail">
        <a
          :href="`https://www.youtube.com/watch?v=${data._videoLink}`"
          target="_blank"
          ><img :src="data._thumbnail" alt="Thumbnail"
        /></a>
      </div>
      <div class="video-details">
        <h2 class="title" v-text="data._title"></h2>
        <p class="description">{{ data._description }}</p>
      </div>
    </div>
  </div>
</template>

<style scoped>
.content {
  text-align: left;
  padding-bottom: 15px;
}
.videos-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  grid-gap: 20px;
}

.video-card {
  display: flex;
  flex-direction: column;
  border: 1px solid #ddd;
  border-radius: 8px;
  overflow: hidden;
  background-color: transparent;
}

.thumbnail img {
  width: 70%;
  height: auto;
  object-fit: cover;
  padding-top: 15px;
  border-radius: 18px;
}

.video-details {
  padding: 10px;
}

.title {
  font-size: 14px;
  margin-bottom: 8px;
  text-align: left;
}

.description {
  font-size: 14px;
  color: #666;
  text-align: left;
}
</style>
