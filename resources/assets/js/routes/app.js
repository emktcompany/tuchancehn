import Opportunities from '@/pages/Opportunities/OpportunityList.vue';
import Opportunity from '@/pages/Opportunities/OpportunityDetail.vue';
import Bidders from '@/pages/Bidders/BidderList.vue';
import Bidder from '@/pages/Bidders/BidderDetail.vue';

export default [
  {
    name: 'opportunities',
    path: '/oportunidades',
    component: Opportunities,
    meta: {
      title: 'Oportunidades'
    }
  },
  {
    name: 'category',
    path: '/categoria/:category',
    component: Opportunities,
    meta: {
      title: function () {
        return this.category.name;
      },
      parent: 'opportunities'
    }
  },
  {
    name: 'opportunity',
    path: '/oportunidad/:slug',
    component: Opportunity,
    meta: {
      title: function () {
        return this.opportunity.data.name;
      },
      parent: 'opportunities'
    }
  },
  {
    name: 'bidders',
    path: '/oferentes',
    component: Bidders,
    meta: {
      title: 'Oferentes'
    }
  },
  {
    name: 'bidder',
    path: '/oferente/:slug',
    component: Bidder,
    meta: {
      title: function () {
        return this.bidder.data.name;
      },
      parent: 'bidders'
    }
  },
];
