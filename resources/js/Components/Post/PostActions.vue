<script setup>
import {computed, ref} from "vue";
import {router} from "@inertiajs/vue3";
import {usePage} from "@inertiajs/vue3";
import useNotifications from "@/Composables/useNotifications";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue"
import SecondaryButton from "@/Components/Button/SecondaryButton.vue"
import PostTags from "@/Components/Post/PostTags.vue"
import ProviderIcon from "@/Components/Account/ProviderIcon.vue";
import PaperAirplaneIcon from "@/Icons/PaperAirplane.vue"

const props = defineProps({
    form: {
        required: true,
        type: Object
    }
});

const {notify} = useNotifications();
const isLoading = ref(false);

const {postId, editAllowed} = usePost();
const {validationPassed} = usePostValidator();

const emit = defineEmits(['submit'])

const accounts = computed(() => {
    return usePage().props.accounts.filter(account => props.form.accounts.includes(account.id));
})

const canSchedule = computed(() => {
    return (postId.value && props.form.accounts.length) &&
        editAllowed.value &&
        validationPassed.value;
});

const publishNow = () => {
    isLoading.value = true;

    axios.post(route('mixpost.posts.schedule', {post: postId.value}), {
        postNow: true
    }).then((response) => {
        notify('success', response.data);

        router.visit(route('mixpost.posts.index'));
    }).catch((error) => {
        if (error.response.status !== 422) {
            notify('error', error.response.data.message);
            return;
        }

        notify('error', error.response.data);
    }).finally(() => {
        isLoading.value = false;
    });
};
</script>
<template>
    <div class="w-full flex items-center justify-end bg-stone-500 border-t border-gray-200 z-10">
        <div class="py-4 flex items-center space-x-xs row-px">
            <PostTags :items="form.tags" @update="form.tags = $event"/>

            <template v-if="editAllowed">
                <PrimaryButton @click="publishNow"
                               :disabled="!canSchedule || isLoading"
                               :isLoading="isLoading"
                               size="md">
                    <PaperAirplaneIcon class="mr-xs"/>
                    Publish now
                </PrimaryButton>
            </template>
        </div>
    </div>
</template>
