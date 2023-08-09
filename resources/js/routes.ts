import HelloWorld from "./views/HelloWorld.vue";
import Wardrobe from "./views/Wardrobe.vue";
import WardrobeOffers from "./views/WardroberOffers.vue";
import DetailLook from "./views/DetailLook.vue";

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
    },
    {
        path: '/look/:id',
        component: DetailLook
    }
]
