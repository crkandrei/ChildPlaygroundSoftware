<script>
window.HOPO_AGENT = {
    url: @json(config('services.hopo_agent.url', 'http://localhost:3000')),
    key: @json(config('services.hopo_agent.key', ''))
};
</script>
