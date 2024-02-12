export declare interface Link {
    id: number;
    original: string;
    slug: string;
    created_at: string;
    url: string;
}

export declare interface LinksCollection {
    data: Link[];
    links: {
        prev?: string;
        next?: string;
    };
}
