import { onMounted, onUnmounted } from 'vue';

export function useClickOutside(elementRef, callback, excludeItemClasses: string[]) {
    const handleClickOutside = (event) => {
        const notApplyCloseFunction = !excludeItemClasses.some((itm) => event.target.classList.contains(itm));

        if (notApplyCloseFunction && elementRef.value && !elementRef.value.contains(event.target)) {
            callback();
        }
    };

    onMounted(() => {
        document.addEventListener('click', handleClickOutside);
    });

    onUnmounted(() => {
        document.removeEventListener('click', handleClickOutside);
    });
}
