 <div x-data="February" class="february" :class="{'cursor-wait' : isLoading}">

        <div x-show="data.label || data.description" class="mb-1 sm:mb-4 flex flex-col gap-1 px-3 py-2 sm:p-0">
                <h2 x-show="data.label" class="font-medium text-xl text-slate-700 m-0" x-text="data.label"></h2>
                <p x-show="data.description" class="text-sm text-gray-500" x-text="data.description"></p>
        </div>

         <div class="february-wrapper" :class="{'pointer-events-none opacity-90 animate-pulse ': isLoading}">
                 <div @click.away="state.open = false" class="february-sidebar">
                         <div class="february-sidebar-responsive-handler">
                                 <label x-text="data.label"></label>
                                 <button @click="state.open = !state.open">
                                         <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                                                 <path x-show="!state.open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                                 <path x-show="state.open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                         </svg>
                                 </button>
                         </div>
                         <nav :class="{'hidden sm:flex': !state.open}" class="february-sidebar-nav">

                                 <template x-for="section in sections">
                                         <a @click="state.open = !state.open" class="february-sidebar-nav-item" :href="section.url ? section.url : '#' + section.id" :class="{
                        'active' : isHash(section.id),
                    }" :target="section.target">
                                                 <i class="february-sidebar-nav-item-icon" :class="[section.icon, isHash(section.id) ? 'active' : 'inactive']"></i>
                                                 <span x-html="section.label"></span>
                                         </a>
                                 </template>


                                 <div class="february-sidebar-nav-credit" x-html="data.credit"></div>
                         </nav>
                 </div>

                 <div class="february-content">


                         <!-- header  -->
                         <div class="february-content-header">
                                 <div class="february-content-header-title">
                                         <div class="february-content-header-icon"><i :class="section.icon"></i></div>
                                         <span x-text="section.label"></span>
                                 </div>
                                 <div>
                                         <button x-show="section.submit" @click.prevent="saveOptions" :disabled="state.saving == true" class="february-btn">
                                                 <span class="dashicons" :class="[state.saving ? 'dashicons-update animate-spin' : 'dashicons-saved']"></span>
                                                 <span x-text="state.saving ? 'Saving...' : 'Save Settings'"></span>
                                         </button>
                                 </div>
                         </div>

                         <!-- main -->
                         <div class="february-content-body">

                                 <template x-show="data.tools && section && section.fields && section.fields.length && !isHash('tools')" x-for="field in section.fields">
                                         <div class="flex items-start gap-2 flex-col sm:flex-row mb-3">

                                                 <template x-if="!section.full">
                                                         <div class="sm:w-1/4 w-full flex items-center gap-1 ">
                                                                 <label x-show="field.label" :for="'february_field_' + field.id" class="font-medium text-sm text-slate-700 cursor-pointer" x-text="field.label"></label>

                                                                 <template x-if="field.hints">
                                                                         <!-- Tooltip -->
                                                                         <div class="february-tooltip" x-data="{over : 0, mouse : 0, timer: null}" @click.prevent="clearTimeout(timer); mouse = !mouse" @click.away="clearTimeout(timer); mouse = 0; over = 0" @mouseover="clearTimeout(timer); timer = setTimeout(() => {over = 1}, 700)" @mouseleave="clearTimeout(timer); timer = setTimeout(() => {over = 0}, 700)">
                                                                                 <i class="february-tooltip-icon dashicons dashicons-info" :class="mouse || over  ? 'text-slate-700' : 'text-slate-400'"></i>
                                                                                 <div x-show="over || mouse" class="february-tooltip-content" x-html="field.hints">

                                                                                 </div>
                                                                         </div>
                                                                 </template>


                                                         </div>
                                                 </template>

                                                 <div class="w-full flex flex-col gap-2 p-0.5">

                                                         <!-- inputs -->
                                                         <template x-if="['text', 'email', 'password', 'datetime-local', 'date', 'number', 'month', 'search', 'tel', 'time', 'url', 'week'].includes(field.type)">
                                                                 <div class="w-full flex items-center gap-2" :class="[field.disabled ? 'opacity-70' : '', field.class]">
                                                                         <span x-show="field.before" x-html="field.before"></span>
                                                                         <input :type="field.type" :id="'february_field_' + field.id" :maxlength="field.maxlength" :min="field.min" :max="field.max" :step="field.step" :name="'february_field_' + field.id" :pattern="field.pattern" class="form-input bg-slate-100 focus:bg-white transition duration-150 rounded-sm w-full border-none ring-slate-200  ring-1 focus:ring-slate-400 placeholder-slate-500 py-2 px-3 focus:border-transparent text-sm" x-model="fields[field.id]" :placeholder="field.placeholder || ''" :required="field.required || false" :readonly="field.readonly || false" :disabled="field.disabled || false">
                                                                         <span x-show="field.after" x-html="field.after"></span>
                                                                 </div>
                                                         </template>


                                                         <!-- hidden field  -->
                                                         <template x-if="['hidden'].includes(field.type)">
                                                                 <input type="hidden" :name="'february_field_' + field.id" :id="'february_field_' + field.id" x-model="fields[field.id]">
                                                         </template>


                                                         <!-- select -->
                                                         <template x-if="['select'].includes(field.type)">
                                                                 <!-- select -->
                                                                 <div class="flex flex-col items-center relative w-52" :class="[field.disabled ? 'opacity-70' : '', field.class]">
                                                                         <div class="w-full">
                                                                                 <template x-if="field.selectDropdown">
                                                                                         <div class="bg-white p-1 flex border border-gray-200 rounded">
                                                                                                 <input x-model="field.search" class="p-1 px-2 z-0 appearance-none outline-none w-full text-gray-800 text-sm z-50" :placeholder="field.placeholder || ''" @click="field.selectDropdown = true">
                                                                                                 <span x-text="field.search"></span>

                                                                                                 <div class="flex items-center text-slate-500 px-1 cursor-pointer" @click="field.selectDropdown = !field.selectDropdown">
                                                                                                         <span class="dashicons dashicons-arrow-down-alt2"></span>
                                                                                                 </div>
                                                                                         </div>
                                                                                 </template>
                                                                                 <template x-if="!field.selectDropdown">
                                                                                         <div class="bg-white p-1 flex border border-gray-200 rounded">
                                                                                                 <button class="p-1 px-2 z-0 outline-none w-full text-gray-800 text-sm text-left" @click="field.selectDropdown = true" x-text="field.options && fields[field.id] && field.options.find(option => option.value == fields[field.id]) ? field.options.find(option => option.value == fields[field.id]).label : field.placeholder">
                                                                                                 </button>


                                                                                                 <div class="flex items-center text-slate-500 px-1 cursor-pointer" @click="field.selectDropdown = !field.selectDropdown">
                                                                                                         <span class="dashicons dashicons-arrow-down-alt2"></span>
                                                                                                 </div>
                                                                                         </div>
                                                                                 </template>
                                                                         </div>
                                                                         <!-- 
                                        <template x-if="field.selectDropdown">
                                            <div @click="field.selectDropdown = false"
                                                class="fixed w-full h-full left-0 top-0"></div>
                                        </template> -->

                                                                         <template x-if="field.selectDropdown">
                                                                                 <div class="absolute shadow-lg top-full z-0 w-full lef-0 rounded max-h-52 scrollbar-thin scrollbar-thumb-teal-700 scrollbar-track-gray-100 overflow-y-auto text-sm">
                                                                                         <div class="flex flex-col w-full">
                                                                                                 <template x-for="option in field.options">
                                                                                                         <div @click="fields[field.id] = option.value;  field.selectDropdown = false; field.search = ''" class="cursor-pointer w-full border-gray-100 rounded-t border-b 
                                            hover:bg-teal-100">
                                                                                                                 <div x-show="field.search ? false : true" class="flex w-full items-center p-2 pl-2 border-transparent bg-white border-l-4 relative hover:bg-slate-100" :class="{'border-teal-600' : option.value === fields[field.id]}">
                                                                                                                         <div class="w-full items-center flex" x-show="option.label">
                                                                                                                                 <div class="mx-2 leading-6" x-html="option.label || ''"></div>
                                                                                                                         </div>
                                                                                                                 </div>
                                                                                                         </div>
                                                                                                 </template>
                                                                                         </div>
                                                                                 </div>
                                                                         </template>
                                                                 </div>


                                                         </template>


                                                         <!-- slider range -->
                                                         <template x-if="['range'].includes(field.type)">
                                                                 <div class="flex items-center gap-2" :class="[field.disabled ? 'opacity-70' : '', field.class]">
                                                                         <span class="text-base text-slate-600 flex items-center min-w-24">
                                                                                 <span x-show="field.before" x-html="field.before"></span>
                                                                                 <input type="number" x-model="fields[field.id]" :id="'february_field_' + field.id" :name="'february_field_' + field.id" class="form-input ring-transparent border border-slate-200 px-2 py-1.5 text-sm w-14 appearance-none focus:ring-slate-500 focus:border-transparent rounded-sm">
                                                                                 <span x-show="field.after" x-html="field.after"></span>
                                                                         </span>
                                                                         <div class="w-full">
                                                                                 <input class="rounded-lg overflow-hidden appearance-none bg-slate-200 h-3 w-full" type="range" :min="field.min" :max="field.max" :step="field.step" x-model="fields[field.id]" />

                                                                         </div>
                                                                 </div>
                                                         </template>


                                                         <!-- checkbox -->
                                                         <template x-if="['checkbox'].includes(field.type)">
                                                                 <div class="flex flex-col gap-2 min-h-14" :class="[field.disabled ? 'opacity-70' : '', field.class]">
                                                                         <label class="relative flex items-center isolate gap-2">
                                                                                 <input type="checkbox" :checked="fields[field.id] == true" :required="field.required" :readonly="field.readonly || false" :disabled="field.disabled || false" x-model="fields[field.id]" class="relative peer z-20 text-teal-600 rounded-sm focus:ring-transparent focus:outline-none border-slate-400" />
                                                                                 <span x-show="field.message" class="relative z-20 text-slate-600 text-sm" x-html="field.message"></span>
                                                                         </label>
                                                                 </div>
                                                         </template>

                                                         <!-- radio -->
                                                         <template x-if="['radio'].includes(field.type)">
                                                                 <div class="flex flex-col gap-2" :class="[field.disabled ? 'opacity-70' : '', field.class]" :id="'february_field_' + field.id">
                                                                         <template x-if="field.options && field.options.length" x-for="(label, option) in field.options">
                                                                                 <label class="flex items-center gap-1.5">
                                                                                         <input type="radio" :value="option" :checked="fields[field.id] == option" :name="'february_field_' + field.id" class="form-radio h-4 w-4 text-teal-600 focus:ring-transparent"><span class="cursor-pointer text-gray-700 text-sm" x-html="label"></span>
                                                                                 </label>
                                                                         </template>
                                                                 </div>
                                                         </template>

                                                         <!-- switch -->

                                                         <template x-if="['switch'].includes(field.type)">

                                                                 <div class="flex items-center cursor-pointer gap-3" :class="[field.disabled ? 'opacity-70' : '', field.class]" @click="fields[field.id] = !fields[field.id]">
                                                                         <div :class="{ 'bg-teal-600': fields[field.id], 'bg-slate-200' : !fields[field.id]}" class="w-10 h-4 flex items-center  rounded-full">
                                                                                 <div class="bg-white w-5 h-5 rounded-full shadow-md transform transition duration-150 ring-1 ring-slate-100" :class="{ 'translate-x-5': fields[field.id]}"></div>
                                                                         </div>
                                                                         <span class="text-slate-600 text-sm" x-html="field.message"></span>
                                                                 </div>

                                                         </template>


                                                         <!-- textarea -->
                                                         <template x-if="['textarea'].includes(field.type)">
                                                                 <textarea :placeholder="field.placeholder" :required="field.required" :class="[field.disabled ? 'opacity-70' : '', field.class]" :readonly="field.readonly || false" :disabled="field.disabled || false" x-model="fields[field.id]" class="february-editor w-full form-textarea border-none ring-1 ring-slate-300 focus:ring-slate-600 rounded-sm text-sm text-slate-600"></textarea>
                                                         </template>

                                                         <!-- button group  -->
                                                         <template x-if="['tab'].includes(field.type)">

                                                                 <div :class="[field.disabled ? 'opacity-70' : '', field.class]">
                                                                         <div class="inline-flex shadow-sm rounded-md overflow-hidden">
                                                                                 <template x-for="option in field.options">
                                                                                         <button x-show="option" type="button" :title="option.label" class="border  border-t border-b last:rounded-r-md border-r-0 last:border-r border-gray-200 first:rounded-l-md  px-3 py-2   flex items-center gap-1 justify-center" :class="[fields[field.id] == option.value ? 'bg-teal-600 text-white' : 'bg-white text-slate-700 hover:bg-gray-100 hover:text-teal-700']" @click.prevent="fields[field.id] = option.value">
                                                                                                 <span x-show="option.icon" class="transform" :class="[option.icon, option.label ? 'scale-90' : '']"></span>
                                                                                                 <span class="text-sm font-medium text-center" x-show="option.label" x-text="option.label"></span>
                                                                                         </button>
                                                                                 </template>
                                                                         </div>
                                                                 </div>
                                                         </template>


                                                         <!-- message  -->
                                                         <template x-if="['message'].includes(field.type)">
                                                                 <div x-show="field.message" :class="[field.class]" class="text-sm text-slate-600 bg-slate-100 p-3 rounded-md" x-text="field.message"></div>
                                                         </template>

                                                         <!-- html  -->
                                                         <template x-if="['html'].includes(field.type)">
                                                                 <div x-show="field.html" x-html="field.html"></div>
                                                         </template>

                                                         <!-- details -->
                                                         <div class="text-xs text-slate-500" x-show="field.details" x-html="field.details"></div>
                                                 </div>
                                         </div>
                                 </template>

                                 <!-- Utility Tools -->
                                 <template x-if="data.tools && section && isHash('tools')">
                                         <section>
                                                 <h2 class="font-medium text-base tracking-wide mb-2">Export Settings</h2>

                                                 <div class="text-slate-500 text-sm">
                                                         You can Export all the settings of <span class="font-medium" x-text="data.label"></span>
                                                         as re-usable JSON file.
                                                         <div class="mt-2 flex items-center gap-2">
                                                                 <button @click.prevent="exportSettings" class="february-btn"> Export
                                                                         JSON</button>
                                                         </div>
                                                 </div>

                                                 <div class="border-b border-slate-100 my-6"></div>


                                                 <h2 class="font-medium text-base tracking-wide mb-2">Import Settings</h2>

                                                 <div class="text-slate-500 text-sm mb-6">
                                                         You can Import all the settings for <span class="font-medium" x-text="data.label"></span> from JSON file. Make sure, the JSON file generated
                                                         through <span x-text="data.label"></span> Tool only. Importing a configuration will
                                                         overwrite the existing settings. Sometimes it may break your site. Do at your risk.
                                                         <div class="mt-2 flex items-center gap-2">
                                                                 <button class="february-btn" @click.prevent="importSettings"> Import
                                                                         JSON </button>
                                                         </div>
                                                 </div>

                                                 <div class="border-b border-slate-100 my-6"></div>

                                                 <h2 class="font-medium text-base tracking-wide mb-2">Reset Settings</h2>

                                                 <div class="text-slate-500 text-sm">
                                                         You can Reset all the settings for <span class="font-medium" x-text="data.label"></span>. It will revert to default settings and remove all the
                                                         customizations you made later. Make sure you have have exported the settings before
                                                         resetting.
                                                         <div class="mt-2 flex items-center gap-2">
                                                                 <button class="february-btn danger" @click.prevent="resetSettings" :disabled="state.settingsResetting == true"> <span x-show="state.settingsResetting" class="bg-white w-3 h-3 border-r-4  border-slate-500 rounded-full animate-spin"></span> <span x-html="state.settingsResetting ? 'Resetting..' : 'Reset Settings'"></span> </button>
                                                         </div>
                                                 </div>
                                         </section>
                                 </template>

                         </div>

                         <!-- footer -->
                         <div x-show="section.submit" class="february-content-header">
                                 <div class="february-content-header-notice">
                                         Last update on 12/12/12
                                 </div>
                                 <div>
                                         <button @click.prevent="saveOptions" :disabled="state.saving == true" class="february-btn">
                                                 <span class="dashicons" :class="[state.saving ? 'dashicons-update animate-spin' : 'dashicons-saved']"></span>
                                                 <span x-text="state.saving ? 'Saving...' : 'Save Settings'"></span>
                                         </button>
                                 </div>
                         </div>

                 </div>
         </div>

 </div>



 <style>
         #wpcontent {
                 padding-left: 0 !important;
         }
 </style>