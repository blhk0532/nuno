<style>
    .video-bg {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  overflow: hidden;
  z-index: -1;
}

.video-bg iframe {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 177.77vh; /* 16:9 aspect ratio */
  height: 100vh;
  transform: translate(-50%, -50%);
  pointer-events: none; /* disables clicking the video */
}
</style>
<div class="video-bg">
      <iframe
    src="https://www.youtube.com/embed/Q71sLS8h9a4?autoplay=1&mute=1&controls=0&showinfo=0&rel=0&loop=1&playlist=Q71sLS8h9a4&modestbranding=0"
    frameborder="0"
    allow="autoplay; encrypted-media"
    allowfullscreen>
  </iframe>
</div>
