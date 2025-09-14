<script>
  window.addEventListener("load", function() {
    setTimeout(() => {
      const perfData = performance.getEntriesByType("navigation")[0];
      const loadTimeMs = perfData.loadEventEnd - perfData.loadEventStart;
      const loadTimeSec = (loadTimeMs / 1000).toFixed(2); // convert to seconds

      console.log("Page load time:", loadTimeSec, "seconds");

      // You can send this data to analytics
      if (loadTimeMs > 3000) {
        console.warn("Page load time is slow:", loadTimeSec, "seconds");
      }
    }, 0);
  });
</script>