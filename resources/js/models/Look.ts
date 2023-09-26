import type Event from "#models/Event.ts";
import type Clothes from "#models/Clothes.ts";

export default interface Look {
    id: number,
    name: string,
    slug: string,
    photo: string,
    events: Event[],
    clothes: Clothes[]
}
