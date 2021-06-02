import initToggleClass from './modules/toggle-class';
import initScrollTo from './modules/scroll-to';
import initSelectBoxPicker from './modules/select';
import initImageLazyLoad from './modules/image-lazyload';
import { mobileMenuHanlder, activeMenuHanlder } from './modules/menu';
import initSlickSlider from './modules/slick-slider';
import initTestimonialSlider from './modules/testimonial-slider';

import './demo';
import '../form-validator';

initToggleClass();
initScrollTo();
initSelectBoxPicker();
initImageLazyLoad();
mobileMenuHanlder();
activeMenuHanlder();
initSlickSlider();
initTestimonialSlider();
