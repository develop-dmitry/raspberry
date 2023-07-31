import HelloWorld from "./components/HelloWorld.vue";
import WardrobeOffers from "@/components/Wardrobe/WardrobeOffers/WardrobeOffers.vue";

export default [
    {
        path: '/',
        component: HelloWorld
    },
    {
        path: '/wardrobe/offers',
        component: WardrobeOffers
    }
]
