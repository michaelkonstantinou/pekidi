import {useRouter} from "vue-router";

export function useNavigation() {
    const router = useRouter()

    function goToEditor(id: number) {
        router.push({'name': 'admin.declarations.edit', 'params': {'id': id}})
    }

    function goToDeclarationIndex() {
        router.push({'name': 'admin.declarations.index'})
    }

    function goTo(routeName: string) {
        router.push({'name': routeName})
    }

    return { goToEditor, goToDeclarationIndex, goTo}
}
