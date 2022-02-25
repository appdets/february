 <div x-data="February" class="february" :class="{'cursor-wait' : isLoading}">

         <div x-show="data.title || data.description" class="mb-1 sm:mb-4 flex flex-col gap-1 px-3 py-2 sm:p-0">
                 <h2 x-show="data.title" class="font-medium text-xl text-slate-700 m-0" x-text="data.title"></h2>
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
                                         <a x-show="logical(section.condition)" @click="state.open = !state.open" class="february-sidebar-nav-item" :href="section.url ? section.url : '#' + section.id" :class="{
                        'active' : isHash(section.id),
                    }" :target="section.target">
                                                 <i class="february-sidebar-nav-item-icon" :class="[section.icon, isHash(section.id) ? 'active' : 'inactive']"></i>
                                                 <span x-html="section.title"></span>
                                         </a>
                                 </template>


                                 <div class="february-sidebar-nav-credit">
                                         <?php echo wp_sprintf('<a href="#" target="_blank" title="A Modern, Robust but Powerful WordPress Option Framework">%s</a>', __('February Framework', 'february')) ?>
                                 </div>
                         </nav>
                 </div>

                 <div class="february-content">


                         <!-- header  -->
                         <div class="february-content-header">
                                 <div class="february-content-header-title">
                                         <div class="february-content-header-icon"><i :class="section.icon"></i></div>
                                         <span x-text="section.title"></span>
                                 </div>
                                 <div>
                                         <button x-show="section.submit !== false" @click.prevent="saveOptions" :disabled="state.saving == true" class="february-btn">
                                                 <span class="dashicons" :class="[state.saving ? 'dashicons-update animate-spin' : 'dashicons-saved']"></span>
                                                 <span x-text="state.saving ? (data.saving || 'Saving...') : (data.save || 'Save Settings')"></span>
                                         </button>
                                 </div>
                         </div>

                         <!-- main -->
                         <div class="february-content-body">
                                 <template x-show="section && section.fields && section.fields.length && !isHash('tools')" x-for="field in section.fields">
                                         <template x-if="logical(field.condition)">
                                                 <div class="flex items-start gap-2 flex-col sm:flex-row mb-4" :class="{
                                                         'pb-4 border-b-2 last:border-none border-dashed border-slate-100' : data.divider
                                                 }">

                                                         <template x-if="!section.full && !['divider', 'space'].includes(field.type) && logical(field.condition)">
                                                                 <div class="sm:w-1/4 w-full flex items-center gap-1 ">
                                                                         <label x-show="field.label" :for="'february_field_' + field.id" class="font-medium text-sm text-slate-700 cursor-pointer flex items-center gap-2">
                                                                                 <span x-text="field.label"></span>

                                                                                 <template x-if="field.required">
                                                                                         <div class="february-tooltip" x-data="{over : 0, mouse : 0, timer: null}" @click.prevent="clearTimeout(timer); mouse = !mouse" @click.away="clearTimeout(timer); mouse = 0; over = 0" @mouseover="clearTimeout(timer); timer = setTimeout(() => {over = 1}, 10)" @mouseleave="clearTimeout(timer); timer = setTimeout(() => {over = 0}, 10)">
                                                                                                 <span :class="mouse || over  ? 'text-red-700' : 'text-red-400'">*</span>
                                                                                                 <div x-show="over || mouse" class="february-tooltip-content min-w-0">Required!</div>
                                                                                         </div>
                                                                                 </template>
                                                                         </label>

                                                                         <template x-if="field.hints || field.instruction || field.tooltip">
                                                                                 <!-- Tooltip -->
                                                                                 <div class="february-tooltip" x-data="{over : 0, mouse : 0, timer: null}" @click.prevent="clearTimeout(timer); mouse = !mouse" @click.away="clearTimeout(timer); mouse = 0; over = 0" @mouseover="clearTimeout(timer); timer = setTimeout(() => {over = 1}, 700)" @mouseleave="clearTimeout(timer); timer = setTimeout(() => {over = 0}, 700)">
                                                                                         <i class="february-tooltip-icon dashicons dashicons-info" :class="mouse || over  ? 'text-slate-700' : 'text-slate-400'"></i>
                                                                                         <div x-show="over || mouse" class="february-tooltip-content" x-html="field.hints || field.instruction || field.tooltip"></div>
                                                                                 </div>
                                                                         </template>


                                                                 </div>
                                                         </template>

                                                         <template x-if="logical(field.condition)">
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
                                                                                                         <div class="fixed top-0 left-0 w-full h-full z-0" @click.prevent="field.selectDropdown = false"></div>
                                                                                                 </template>
                                                                                                 <template x-if="field.selectDropdown">
                                                                                                         <div class="bg-white p-1 flex border border-gray-200 rounded">
                                                                                                                 <input x-model="field.search" class="p-1 px-2   appearance-none outline-none w-full text-gray-800 text-sm z-50" :placeholder="field.placeholder || ''" @click.prevent="field.selectDropdown = true">

                                                                                                                 <div class="flex items-center text-slate-500 px-1 cursor-pointer" @click="field.selectDropdown = !field.selectDropdown">
                                                                                                                         <span class="dashicons dashicons-arrow-down-alt2"></span>
                                                                                                                 </div>
                                                                                                         </div>
                                                                                                 </template>
                                                                                                 <template x-if="!field.selectDropdown">
                                                                                                         <div class="bg-white p-1 flex border border-gray-200 rounded">
                                                                                                                 <button class="p-1 px-2 z-0 outline-none w-full text-gray-800 text-sm text-left" @click="field.selectDropdown = !field.selectDropdown" @click.away="field.selectDropdown = false">
                                                                                                                         <template x-if="field.options && build_options(field.options).find(opt => opt.value == fields[field.id]) && build_options(field.options).find(opt => opt.value == fields[field.id]).icon">
                                                                                                                                 <span :class="build_options(field.options).find(opt => opt.value == fields[field.id]).icon"></span>
                                                                                                                         </template>
                                                                                                                         <span x-text="field.options && build_options(field.options).find(opt => opt.value == fields[field.id]) ? build_options(field.options).find(opt => opt.value == fields[field.id]).label || field.placeholder : field.placeholder"></span>
                                                                                                                 </button>


                                                                                                                 <div class="flex items-center text-slate-500 px-1 cursor-pointer" @click="field.selectDropdown = !field.selectDropdown">
                                                                                                                         <span class="dashicons dashicons-arrow-down-alt2"></span>
                                                                                                                 </div>
                                                                                                         </div>
                                                                                                 </template>
                                                                                         </div>

                                                                                         <template x-if="field.selectDropdown">
                                                                                                 <div class="absolute shadow-lg top-full z-50 w-full lef-0 rounded max-h-52 scrollbar-thin scrollbar-thumb-teal-700 scrollbar-track-gray-100 overflow-y-auto text-sm">
                                                                                                         <div class="flex flex-col w-full">
                                                                                                                 <template x-for="option in build_options(field.options)">
                                                                                                                         <div x-show="!field.search ? true : (option.label.toLowerCase().includes(field.search.toLowerCase()) || option.value.toLowerCase().includes(field.search.toLowerCase()))" @click="fields[field.id] = option.value;  field.selectDropdown = false; field.search = ''" class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-teal-100">
                                                                                                                                 <div x-show="field.search ? false : true" class="flex w-full items-center p-2 pl-2 border-transparent  border-l-4 relative hover:bg-slate-100" :class="[option.value === fields[field.id] ? 'border-teal-600 bg-slate-100' : 'bg-white']">
                                                                                                                                         <span x-show="option.icon" :class="option.icon"></span>
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
                                                                                 <label class="flex items-center gap-1.5 rounded-md">
                                                                                         <input x-model="fields[field.id]" :name="'february_field_' + field.id" :name="'february_field_' + field.id" type="checkbox" class="hidden peer" />
                                                                                         <span class="w-4 h-4 rounded-sm bg-slate-200 peer-checked:bg-teal-600 text-transparent peer-checked:text-white transition duration-150 flex items-center justify-center">
                                                                                                 <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-2.5" viewBox="0 0 24 24">
                                                                                                         <path d="M0 11.386l1.17-1.206c1.951.522 5.313 1.731 8.33 3.597 3.175-4.177 9.582-9.398 13.456-11.777l1.044 1.073-14 18.927-10-10.614z" />
                                                                                                 </svg>
                                                                                         </span>
                                                                                         <span x-show="field.label" x-text="field.label" class="text-sm"></span>
                                                                                 </label>
                                                                         </template>

                                                                         <!-- multiple checkbox -->
                                                                         <template x-if="['multi_checkbox'].includes(field.type)">
                                                                                 <div class="flex gap-3" :class="[field.inline ? 'flex-row items-center' : 'flex-col', field.class]">
                                                                                         <template x-show="field.options && field.options.length" x-for="option in build_options(field.options)">
                                                                                                 <template x-if="option && option.value">
                                                                                                         <label class="flex items-center gap-1.5 rounded-md">
                                                                                                                 <input x-model="fields[field.id][option.value]" :name="'february_field_' + field.id + '_' + option.value" type="checkbox" class="hidden peer" />
                                                                                                                 <span class="w-4 h-4 rounded-sm bg-slate-200 peer-checked:bg-teal-600 text-transparent peer-checked:text-white transition duration-150 flex items-center justify-center">
                                                                                                                         <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-2.5" viewBox="0 0 24 24">
                                                                                                                                 <path d="M0 11.386l1.17-1.206c1.951.522 5.313 1.731 8.33 3.597 3.175-4.177 9.582-9.398 13.456-11.777l1.044 1.073-14 18.927-10-10.614z" />
                                                                                                                         </svg>
                                                                                                                 </span>
                                                                                                                 <span x-show="option.label" x-text="option.label" class="text-sm"></span>
                                                                                                         </label>
                                                                                                 </template>
                                                                                         </template>
                                                                                 </div>
                                                                         </template>

                                                                         <!-- multiple checkbox -->
                                                                         <template x-if="['multi_switch'].includes(field.type)">
                                                                                 <div class="flex gap-3" :class="[field.inline ? 'flex-row items-center' : 'flex-col', field.class]">
                                                                                         <template x-show="field.options && field.options.length" x-for="option in build_options(field.options)">

                                                                                                 <label x-show="option && option.value" class="flex items-center cursor-pointer gap-3" :class="[field.disabled ? 'opacity-70' : '', field.class]" @click="fields[field.id][option.value] = !fields[field.id][option.value]">
                                                                                                         <div :class="{ 'bg-teal-600': fields[field.id][option.value], 'bg-slate-200' : !fields[field.id][option.value]}" class="w-10 h-4 flex items-center  rounded-full">
                                                                                                                 <div class="bg-white w-5 h-5 rounded-full shadow-md transform transition duration-150 ring-1 ring-slate-100" :class="{ 'translate-x-5': fields[field.id][option.value]}"></div>
                                                                                                         </div>
                                                                                                         <span class="text-slate-600 text-sm" x-html="option.label"></span>
                                                                                                 </label>

                                                                                         </template>
                                                                                 </div>
                                                                         </template>

                                                                         <!-- radio -->
                                                                         <template x-if="['radio'].includes(field.type)">
                                                                                 <div class="flex gap-2" :class="[field.disabled ? 'opacity-70' : '', field.class, field.inline ? 'flex-row gap-4' : 'flex-col']" :id="'february_field_' + field.id">
                                                                                         <template x-if="field.options && field.options.length" x-for="option in build_options(field.options)">
                                                                                                 <label class="flex items-center gap-1.5 rounded-md" @click="fields[field.id] = option.value">
                                                                                                         <input :value="option.value" :checked="fields[field.id] == option.value" :name="'february_field_' + field.id" :name="'february_field_' + field.id + '_' + option.value" type="radio" class="hidden peer" />
                                                                                                         <span class="w-4 h-4 rounded-full bg-slate-200 peer-checked:bg-teal-600 transition duration-150 flex items-center justify-center">
                                                                                                                 <span class="bg-white w-2 h-2 block rounded-full"></span>
                                                                                                         </span>
                                                                                                         <span x-show="option.label" x-text="option.label" class="text-sm"></span>
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
                                                                                 <textarea :placeholder="field.placeholder" :rows="field.rows || 2" :required="field.required" :class="[field.disabled ? 'opacity-70' : '', field.class]" :readonly="field.readonly || false" :disabled="field.disabled || false" x-model="fields[field.id]" class="february-editor w-full form-textarea bg-slate-100 border-none ring-1 ring-slate-200 focus:ring-slate-400 focus:bg-white rounded-sm text-sm transition duration-150 text-slate-600"></textarea>
                                                                         </template>

                                                                         <!-- button group  -->
                                                                         <template x-if="['tab'].includes(field.type)">
                                                                                 <div :class="[field.disabled ? 'opacity-70' : '', field.class]">
                                                                                         <div class="inline-flex shadow-sm rounded-md ">
                                                                                                 <template x-for="option in build_options(field.options)">
                                                                                                         <button x-show="option.value" type="button" :title="option.label" class="border  border-t border-b last:rounded-r-sm border-r-0 last:border-r border-gray-200 first:rounded-l-sm  px-2 py-1.5  flex items-center gap-1 justify-center" :class="[fields[field.id] == option.value ? 'bg-teal-600 text-white' : 'bg-white text-slate-700 hover:bg-gray-100 hover:text-teal-700']" @click.prevent="fields[field.id] = option.value">
                                                                                                                 <span x-show="option.icon" class="transform" :class="[option.icon, option.label ? 'scale-90' : '']"></span>
                                                                                                                 <span class="text-sm font-medium text-center" x-show="option.label && option.label != 0" x-text="option.label"></span>
                                                                                                         </button>

                                                                                                 </template>
                                                                                         </div>
                                                                                 </div>
                                                                         </template>


                                                                         <!-- message  -->
                                                                         <template x-if="['message'].includes(field.type)">
                                                                                 <div x-show="field.html || field.message || field.text" :class="[field.class]" class="text-sm text-slate-600 bg-slate-100 p-3 rounded-md" x-text="field.html || field.message || field.text"></div>
                                                                         </template>

                                                                         <!-- html  -->
                                                                         <template x-if="['html'].includes(field.type)">
                                                                                 <div x-show="field.html || field.message || field.text" x-html="field.html || field.message || field.text"></div>
                                                                         </template>


                                                                         <!-- divider  -->
                                                                         <template x-if="['divider'].includes(field.type)">
                                                                                 <div class="border-b-2 border-dashed border-slate-100 my-2"></div>
                                                                         </template>

                                                                         <!-- space  -->
                                                                         <template x-if="['space'].includes(field.type)">
                                                                                 <div class="my-2"></div>
                                                                         </template>

                                                                         <!-- details -->
                                                                         <div class="text-xs text-slate-500" x-show="field.description" x-html="field.description"></div>
                                                                 </div>

                                                         </template>

                                                 </div>
                                         </template>

                                 </template>

                                 <!-- Utility Tools -->
                                 <template x-if="data.enable_tools && section && section.id === 'tools'">
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
                         <div x-show="section.submit !== false" class="february-content-header">
                                 <div class="february-content-header-notice">
                                         <button @click.prevent="resetSection" :disabled="state.saving == true" class="february-btn danger">
                                                 <span x-text="state.sectionResetting ? (data.resetting || 'Resetting...') : (data.reset || 'Reset Section')"></span>
                                         </button>
                                 </div>
                                 <div>
                                         <button @click.prevent="saveOptions" :disabled="state.saving == true" class="february-btn">
                                                 <span class="dashicons" :class="[state.saving ? 'dashicons-update animate-spin' : 'dashicons-saved']"></span>
                                                 <span x-text="state.saving ? (data.saving || 'Saving...') : (data.save || 'Save Settings')"></span>
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