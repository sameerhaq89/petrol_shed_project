@extends('super-admin.layouts.master')

@section('title', 'Dashboard - SuperAdmin Panel')

@section('content')
    <div class="dashboard-container">
        <!-- Page Title -->
        <h1 class="page-title">Dashboard Overview</h1>

        <!-- Stats Cards -->
        <div class="stats-grid">
            @include('super-admin.components.stat-card', [
                'title' => 'Total Subscriptions',
                'value' => '1,250',
                'icon' => 'fas fa-arrow-up',
                'iconClass' => 'icon-green',
                'trend' => 'up',
            ])

            @include('super-admin.components.stat-card', [
                'title' => 'Active Stations',
                'value' => '350',
                'icon' => 'fas fa-gas-pump',
                'iconClass' => 'icon-blue',
            ])

            @include('super-admin.components.stat-card', [
                'title' => 'Total Users',
                'value' => '4,800',
                'icon' => 'fas fa-users',
                'iconClass' => 'icon-blue',
            ])

            @include('super-admin.components.stat-card', [
                'title' => 'Revenue (MTD)',
                'value' => '$52,000',
                'icon' => 'fas fa-dollar-sign',
                'iconClass' => 'icon-blue',
            ])
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Recent Subscriptions -->
            <div class="dashboard-card recent-subscriptions">
                <h2 class="card-title">Recent Subscriptions</h2>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Plan</th>
                                <th>Station</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>3581</td>
                                <td>Plan Plan</td>
                                <td>Station #01</td>
                                <td>Aug 29, 2023</td>
                                <td><span class="badge badge-success">Active</span></td>
                            </tr>
                            <tr>
                                <td>3582</td>
                                <td>Shaen Plan</td>
                                <td>Station #02</td>
                                <td>Sep 20, 2023</td>
                                <td><span class="badge badge-success">Active</span></td>
                            </tr>
                            <tr>
                                <td>3533</td>
                                <td>Single Plan</td>
                                <td>Station #03</td>
                                <td>Aug 20, 2023</td>
                                <td><span class="badge badge-warning">Pending</span></td>
                            </tr>
                            <tr>
                                <td>3874</td>
                                <td>Bhoan Plan</td>
                                <td>Station #04</td>
                                <td>Sep 20, 2023</td>
                                <td><span class="badge badge-success">Active</span></td>
                            </tr>
                            <tr>
                                <td>3865</td>
                                <td>Plan Plan</td>
                                <td>Station #05</td>
                                <td>Sep 20, 2023</td>
                                <td><span class="badge badge-success">Active</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- New Stations -->
            <div class="dashboard-card new-stations">
                <h2 class="card-title">New Stations</h2>
                <div class="stations-list">
                    <div class="station-item">
                        <div class="station-info">
                            <h3 class="station-name">Station Station 1</h3>
                            <p class="station-location">Location, Rusia</p>
                        </div>
                        <a href="#" class="btn-view">View</a>
                    </div>

                    <div class="station-item">
                        <div class="station-info">
                            <h3 class="station-name">Station Station 2</h3>
                            <p class="station-location">Location, Patianta</p>
                        </div>
                        <a href="#" class="btn-view">View</a>
                    </div>

                    <div class="station-item">
                        <div class="station-info">
                            <h3 class="station-name">Station Station 3</h3>
                            <p class="station-location">Location, Rusia</p>
                        </div>
                        <a href="#" class="btn-view">View</a>
                    </div>

                    <div class="station-item">
                        <div class="station-info">
                            <h3 class="station-name">Station Station 4</h3>
                            <p class="station-location">Location, Patianta</p>
                        </div>
                        <a href="#" class="btn-view">View</a>
                    </div>

                    <div class="station-item">
                        <div class="station-info">
                            <h3 class="station-name">Station Station 5</h3>
                            <p class="station-location">Location, Place</p>
                        </div>
                        <a href="#" class="btn-view">View</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
