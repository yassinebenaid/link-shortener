import { PageProps as InertiaPageProps } from "@inertiajs/core";
import { type AxiosStatic } from "axios";
import ziggyRoute, { Config as ZiggyConfig } from "ziggy-js";

declare global {
    interface Window {
        axios: AxiosStatic;
    }

    var route: typeof ziggyRoute;
    var Ziggy: ZiggyConfig;
}

declare module "vue" {
    interface ComponentCustomProperties {
        route: typeof ziggyRoute;
    }
}

declare module "@inertiajs/core" {
    interface PageProps extends InertiaPageProps {}
}
