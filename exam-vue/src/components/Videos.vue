<script>
export default {
  name: "Videos",
  components: {},
  data() {
    return {
      jsonData: [],
      currentPage: 1,
      videosPerPage: 20,
    };
  },
  computed: {
  displayedVideos() {
    const startIndex = (this.currentPage - 1) * this.videosPerPage;
    const endIndex = startIndex + this.videosPerPage;
    return this.jsonData.slice(startIndex, endIndex);
  },
  totalPages() {
    return Math.ceil(this.jsonData.length / this.videosPerPage);
  },
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
    toggleDescription(video) {
      video.showDescription = !video.showDescription;
    },
    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
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
    <div v-for="data in displayedVideos" 
    :key="data.id" 
    class="video-card">
      <div class="thumbnail">
        <a
          :href="`https://www.youtube.com/watch?v=${data._videoLink}`"
          target="_blank">
          <img :src="data._thumbnail" alt="Thumbnail"
        />
      </a>
      </div>
      <div class="video-details">
        <h2 class="title" v-text="data._title"></h2>
        <p class="description" :class="{ 'hide': !data.showDescription }">{{ data._description }}</p>
        <button class="toggle-description" @click="toggleDescription(data)">
          {{ data.showDescription ? 'Show Less' : 'Show More' }}
        </button>
      </div>
    </div>
  </div>
  <div class="pagination">
    <button @click="previousPage" :disabled="currentPage === 1">Previous</button>
  <button
    v-for="page in totalPages"
    :key="page"
    :class="{ active: currentPage === page }"
    @click="currentPage = page">
    {{ page }}
  </button>
  <button @click="nextPage" :disabled="currentPage === totalPages">Next</button>
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
  overflow: hidden;
  max-height: 200px;
  transition: max-height 0.3s ease;
  text-overflow: ellipsis;
}
.hide {
  max-height: 0;
}
.toggle-description {
  margin-top: 15px;
  background: none;
  border: none;
  color: #666;
  cursor: pointer;
}
.pagination {
  margin-top: 20px;
}
.pagination button {
  padding: 15px 20px;
  margin-right: 5px;
  background-color: #242424;
  color: #eee;
  border: 1px solid #eee;
  border-radius: 4px;
  cursor: pointer;
}
.pagination button.active {
  background-color: #666;
}
.pagination button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
.pagination button:hover{
  background-color: #666;
}
</style>
