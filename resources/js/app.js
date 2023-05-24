import Alpine from 'alpinejs'
import Focus from '@alpinejs/focus'
import FormsAlpinePlugin from '../../vendor/filament/forms/dist/module.esm'
import NotificationsAlpinePlugin from '../../vendor/filament/notifications/dist/module.esm'
import AlpineFloatingUI from '@awcodes/alpine-floating-ui'
import { setPrefersDarkMode } from '../../resources/js/helpers/preferences/index'


Alpine.plugin(Focus)
Alpine.plugin(FormsAlpinePlugin)
Alpine.plugin(AlpineFloatingUI)
Alpine.plugin(NotificationsAlpinePlugin)

window.Alpine = Alpine
window.setPrefersDarkMode = setPrefersDarkMode;
window.setPrefersDarkMode && setPrefersDarkMode();

Alpine.start()
