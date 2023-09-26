<script lang="ts">
import Page from "#ui/page/Page.vue";
import Heading from "#ui/heading/Heading.vue";
import Container from "#ui/container/Container.vue";
import ClothesCard from "#components/wardrobe/clothes-card/ClothesCard.vue";
import {defineComponent, computed, ref, onMounted, Ref} from "vue";
import {useWardrobeStore} from "#stores/wardrobe-store/WardrobeStore.ts";
import Clothes from "#models/Clothes.ts";

export default defineComponent({
    components: {
        Page,
        Heading,
        Container,
        ClothesCard
    },

    props: {
        count: {
            type: Number,
            required: true
        },
        total: {
            type: Number,
            required: true
        }
    },

    setup({ count, total }) {
        const wardrobeStore = useWardrobeStore();

        let page: Ref<number> = ref(0);
        const row = ref();

        let isLoading: Ref<boolean> = ref(false);
        const items: Ref<Clothes[]> = ref([]);

        const lastPage = computed<number>((): number => Math.round(total / count) + 1);
        const isLastPage = computed<boolean>((): boolean => page.value === lastPage.value);

        const load = async () => {
            if (isLoading.value) {
                return;
            }

            isLoading.value = true;

            try {
                const response = await wardrobeStore.fetchOffers({ page: ++page.value, count });

                items.value.push(...response.items);
            } catch (e) {
                console.error(e);
            } finally {
                isLoading.value = false;
            }
        };


        const check = () => {
            if (isLastPage.value) {
                window.removeEventListener('scroll', check);
                return;
            }

            if (!row.value) {
                return;
            }

            const lastElement: HTMLElement | null = (row.value as HTMLElement).querySelector(':scope > :last-child');

            if (lastElement && window.scrollY > lastElement.offsetTop - window.innerHeight) {
                load();
            }
        }

        const updateWardrobe = async () => {
            const clothes = await wardrobeStore.fetchWardrobe();

            wardrobeStore.setClothes(clothes);
        }

        onMounted(() => {
            load();
            window.addEventListener('scroll', check);
        });

        return {
            row,
            items,
            updateWardrobe
        }
    }
});
</script>

<template lang="pug">
Page.offers
    Container
        Heading Добавьте в свой гардероб
        .offers__row(ref="row")
            ClothesCard(
                v-for="item in items"
                :key="item.id"
                :clothes="item"
                @add="updateWardrobe"
                @remove="updateWardrobe"
            )
</template>

<style scoped lang="scss">
.offers__row {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;

    @include media-always {
        margin-top: 50px;
    }

    > * {
        flex-basis: calc(33.3% - 30px * 2 / 3);

        @include media-max($mobile) {
            flex-basis: 100%;
        }
    }
}
</style>
