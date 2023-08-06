import HelloWorld from "./views/HelloWorld.vue";
import Wardrobe from "./views/Wardrobe.vue";
import WardrobeOffers from "./views/WardroberOffers.vue";

export default [
    {
        path: '/',
        component: HelloWorld
    },
    {
        path: '/wardrobe',
        component: Wardrobe
    },
    {
        path: '/wardrobe/offers',
        component: WardrobeOffers
    }
]
