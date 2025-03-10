<script setup>
definePageMeta({
  middleware: ['admin']
});

const router = useRouter();

onMounted(() => {
  router.push('/admin/panel');
});
</script>

<template>
  <div>Redirection...</div>
</template> 