<x-layout>
    <div class="bg-white mx-auto p-8 rounded-lg shadow-md w-full md:max-w-3xl">
        <h2 class="text-4xl text-center font-bold mb-4">
            Update Job Listing - "{{ $job->title }}"
        </h2>
        <form method="POST" action="{{ route('jobs.update', $job) }}" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                Job Info
            </h2>

            <x-inputs.text name="title" label="Job Title" value="{{ $job->title }}" placeholder="Software Engineer" />

            <x-inputs.text-area id="description" name="description" value="{{ $job->description }}"
                label="Job Description"
                placeholder="We are seeking a skilled and motivated Software Developer to join our growing development team..." />

            <x-inputs.text name="salary" value="{{ $job->salary }}" type="number" label="Annual Salary"
                placeholder="50000" />

            <x-inputs.text-area id="requirements" value="{{ $job->requirements }}" name="requirements"
                label="Requirements" placeholder="Bachelor's degree in Computer Science" />

            <x-inputs.text-area id="benefits" value="{{ $job->benefits }}" name="benefits" label="Benefits"
                placeholder="Health insurance, 401k, paid time off" />

            <x-inputs.text name="tags" value="{{ $job->tags }}" label="Tags (comma-separated)"
                placeholder="development,coding,java,python" />

            <x-inputs.select id="job_type" name="job_type" label="Job Type" value="{{ $job->job_type }}"
                :options="[
                    'Full-Time' => 'Full-Time',
                    'Part-Time' => 'Part-Time',
                    'Contract' => 'Contract',
                    'Temporary' => 'Temporary',
                    'Internship' => 'Internship',
                    'Volunteer' => 'Volunteer',
                    'On-Call' => 'On-Call',
                ]" />

            <x-inputs.select id="remote" name="remote" value="{{ $job->remote }}" label="Remote"
                :options="[
                    0 => 'No',
                    1 => 'Yes',
                ]" />

            <x-inputs.text name="address" value="{{ $job->address }}" label="Address" placeholder="123 Main St" />

            <x-inputs.text name="city" value="{{ $job->city }}" label="City" placeholder="Albanyt" />

            <x-inputs.text name="state" value="{{ $job->state }}" label="State" placeholder="NY" />

            <x-inputs.text name="zipcode" value="{{ $job->zipcode }}" label="ZIP Code" placeholder="12201" />

            <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                Company Info
            </h2>

            <x-inputs.text name="company_name" value="{{ $job->company_name }}" label="Company Name"
                placeholder="Company Name" />

            <x-inputs.text-area id="company_description" value="{{ $job->company_description }}"
                name="company_description" label="Company Description" placeholder="Company Description" />

            <x-inputs.text name="company_website" value="{{ $job->company_website }}" type="url"
                label="Company Website" placeholder="Enter website" />

            <x-inputs.text name="contact_phone" value="{{ $job->contact_phone }}" label="Contact Phone"
                placeholder="Enter Phone" />

            <x-inputs.text name="contact_email" value="{{ $job->contact_email }}" label="Contact Email"
                placeholder="Enter Email" />

            <x-inputs.file name="company_logo" value="{{ $job->company_logo }}" id="company_logo"
                label="Company Logo" />

            <button type="submit"
                class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none">
                Save
            </button>
        </form>
    </div>
</x-layout>
