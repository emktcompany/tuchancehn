import Paginate from 'vuejs-paginate';

export default {
  install(Vue) {
    Vue.component('pagination-links', Paginate);

    Vue.component('svg-icon', require('@/components/SvgIcon.vue'));
    Vue.component('animated-number', require('@/components/AnimatedNumber.vue'));

    Vue.component('country-menu', require('@/components/navigation/CountryMenu.vue'));
    Vue.component('breadcrumbs-list', require('@/components/navigation/BreadcrumbsList.vue'));
    Vue.component('auth-nav', require('@/components/navigation/AuthNav.vue'));
    Vue.component('user-nav', require('@/components/navigation/UserNav.vue'));

    Vue.component('search-form', require('@/components/SearchForm.vue'));
    Vue.component('search-in', require('@/components/tuchance/SearchIn.vue'));

    Vue.component('alert-box', require('@/components/shared/AlertBox.vue'));
    Vue.component('modal-dialog', require('@/components/shared/ModalDialog.vue'));

    Vue.component('location-name', require('@/components/tuchance/LocationName.vue'));
    Vue.component('opportunity-detail', require('@/components/tuchance/OpportunityDetail.vue'));
    Vue.component('opportunity-preview', require('@/components/tuchance/OpportunityPreview.vue'));
    Vue.component('bidder-preview', require('@/components/tuchance/BidderPreview.vue'));
    Vue.component('bidder-detail', require('@/components/tuchance/BidderDetail.vue'));
    Vue.component('category-pill', require('@/components/tuchance/CategoryPill.vue'));
    Vue.component('category-badge', require('@/components/tuchance/CategoryBadge.vue'));
    Vue.component('home-carousel', require('@/components/tuchance/HomeCarousel.vue'));

    Vue.component('wysiwyg', () => import(/* webpackChunkName: "editor" */ '@/components/form/WysiwygEditor.vue'));
    Vue.component('base-chart', () => import(/* webpackChunkName: "chart" */ '@/components/admin/BaseChart.vue'));

    Vue.component('v-draggable', () => import(/* webpackChunkName: "sortable" */ 'vuedraggable'));

    Vue.component('v-select', () => import(/* webpackChunkName: "select" */ 'vue-select'));
    Vue.component('choice-input', () => import(/* webpackChunkName: "select" */ '@/components/form/ChoiceInput.vue'));

    Vue.component('remaining-count', () => import(/* webpackChunkName: "form" */ '@/components/form/RemainingCount.vue'));
    Vue.component('form-field', () => import(/* webpackChunkName: "form" */ '@/components/form/FormField.vue'));
    Vue.component('password-input', () => import(/* webpackChunkName: "form" */ '@/components/form/PasswordInput.vue'));
    Vue.component('date-input', () => import(/* webpackChunkName: "form" */ '@/components/form/DateInput.vue'));
    Vue.component('tel-input', () => import(/* webpackChunkName: "form" */ '@/components/form/PhoneInput.vue'));
    Vue.component('radio-group', () => import(/* webpackChunkName: "form" */ '@/components/form/RadioGroup.vue'));
    Vue.component('select-input', () => import(/* webpackChunkName: "form" */ '@/components/form/SelectInput.vue'));
    Vue.component('country-select', () => import(/* webpackChunkName: "form" */ '@/components/form/CountrySelect.vue'));
    Vue.component('state-select', () => import(/* webpackChunkName: "form" */ '@/components/form/StateSelect.vue'));
    Vue.component('city-select', () => import(/* webpackChunkName: "form" */ '@/components/form/CitySelect.vue'));
    Vue.component('confirm-button', () => import(/* webpackChunkName: "form" */ '@/components/form/ConfirmButton.vue'));
    Vue.component('toggle-button', () => import(/* webpackChunkName: "form" */ '@/components/form/ToggleButton.vue'));
    Vue.component('toggle-pill', () => import(/* webpackChunkName: "form" */ '@/components/form/TogglePill.vue'));
    Vue.component('image-input', () => import(/* webpackChunkName: "form" */ '@/components/form/ImageInput.vue'));
    Vue.component('file-input', () => import(/* webpackChunkName: "form" */ '@/components/form/FileInput.vue'));
    Vue.component('date-range-picker', () => import(/* webpackChunkName: "range" */ '@/components/form/DateRangePicker.vue'));

    Vue.component('image-cropper', () => import(/* webpackChunkName: "cropper" */ '@/components/form/ImageCropper.vue'));
    Vue.component('cropper-modal', () => import(/* webpackChunkName: "cropper" */ '@/components/form/CropperModal.vue'));

    Vue.component('candidate-detail', () => import(/* webpackChunkName: "auth" */ '@/components/tuchance/CandidateDetail.vue'));
    Vue.component('login-form', () => import(/* webpackChunkName: "auth" */ '@/components/auth/LoginForm.vue'));
    Vue.component('facebook-button', () => import(/* webpackChunkName: "auth" */ '@/components/auth/FacebookButton.vue'));
    Vue.component('google-button', () => import(/* webpackChunkName: "auth" */ '@/components/auth/GoogleButton.vue'));

    Vue.component('export-form', () => import(/* webpackChunkName: "export" */ '@/components/admin/ExportForm.vue'));
    Vue.component('import-form', () => import(/* webpackChunkName: "export" */ '@/components/admin/ImportForm.vue'));

    Vue.component('admin-nav', () => import(/* webpackChunkName: "admin" */ '@/components/admin/AdminNav.vue'));
    Vue.component('admin-menu-item', () => import(/* webpackChunkName: "admin" */ '@/components/admin/AdminMenuItem.vue'));
    Vue.component('index-view', () => import(/* webpackChunkName: "admin" */ '@/components/admin/IndexView.vue'));
    Vue.component('sortable-view', () => import(/* webpackChunkName: "admin" */ '@/components/admin/SortableView.vue'));
    Vue.component('stat-box', () => import(/* webpackChunkName: "admin" */ '@/components/admin/StatBox.vue'));
  }
}
