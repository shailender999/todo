<template>
  <li
    class="flex row items-center justify-between w-full py-1 px-4 my-1 rounded border bg-gray-100 text-gray-600"
  >
    <div class="items-center column">
      <input
        class="mx-1"
        type="checkbox"
        :checked="desc.completed === 1"
        @input="$emit('toggle', desc.id)"
      >
      <span :class="{'line-through': desc.completed === 1}">{{ desc.title }}</span>
    </div>
    <div class="items-center row-reverse">
      <span class="px-4 py-2 float-right" @click="$emit('remove', desc.id)">
        <svgicon icon="delete" width="22" height="18" color="red"></svgicon>
      </span>
    </div>
  </li>
</template>
<script>
import '@/compiled-icons/delete';
export default {
  props: {
    desc: { type: Object, required: true }
  }
};
</script>
