<?php

namespace DerrickSmith\HaloApi\Facades;

use DerrickSmith\HaloApi\HaloApi;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array getActions(array $array = [])
 * @method static array getAction(array $array = [])
 * @method static array postActions(array $array = [])
 * @method static array deleteActions(array $array = [])
 * @method static array getAgents(array $array = [])
 * @method static array getAgent(array $array = [])
 * @method static array getAgentSelf()
 * @method static array postAgent(array $array = [])
 * @method static array deleteAgent(array $array = [])
 * @method static array getAppointments(array $array = [])
 * @method static array getAppointment(array $array = [])
 * @method static array postAppointment(array $array = [])
 * @method static array deleteAppointment(array $array = [])
 * @method static array getAssets(array $array = [])
 * @method static array getAsset(array $array = [])
 * @method static array postAsset(array $array = [])
 * @method static array deleteAsset(array $array = [])
 * @method static array getAttachments(array $array = [])
 * @method static array getAttachment(array $array = [])
 * @method static array postAttachment(array $array = [])
 * @method static array deleteAttachment(array $array = [])
 * @method static array getClients(array $array = [])
 * @method static array getClient(array $array = [])
 * @method static array postClient(array $array = [])
 * @method static array deleteClient(array $array = [])
 * @method static array getContracts(array $array = [])
 * @method static array getContract(array $array = [])
 * @method static array postContract(array $array = [])
 * @method static array deleteContract(array $array = [])
 * @method static array getInvoices(array $array = [])
 * @method static array getInvoice(array $array = [])
 * @method static array postInvoice(array $array = [])
 * @method static array deleteInvoice(array $array = [])
 * @method static array getItems(array $array = [])
 * @method static array getItem(array $array = [])
 * @method static array postItem(array $array = [])
 * @method static array deleteItem(array $array = [])
 * @method static array getKbArticles(array $array = [])
 * @method static array getKbArticle(array $array = [])
 * @method static array postKbArticle(array $array = [])
 * @method static array deleteKbArticle(array $array = [])
 * @method static array getOpportunities(array $array = [])
 * @method static array getOpportunity(array $array = [])
 * @method static array postOpportunity(array $array = [])
 * @method static array deleteOpportunity(array $array = [])
 * @method static array getProjects(array $array = [])
 * @method static array getProject(array $array = [])
 * @method static array postProject(array $array = [])
 * @method static array deleteProject(array $array = [])
 * @method static array getQuotes(array $array = [])
 * @method static array getQuote(array $array = [])
 * @method static array postQuote(array $array = [])
 * @method static array deleteQuote(array $array = [])
 * @method static array getReports(array $array = [])
 * @method static array getReport(array $array = [])
 * @method static array postReport(array $array = [])
 * @method static array deleteReport(array $array = [])
 * @method static array getSites(array $array = [])
 * @method static array getSite(array $array = [])
 * @method static array postSite(array $array = [])
 * @method static array deleteSite(array $array = [])
 * @method static array getStatuses(array $array = [])
 * @method static array getStatus(array $array = [])
 * @method static array postStatus(array $array = [])
 * @method static array deleteStatus(array $array = [])
 * @method static array getSuppliers(array $array = [])
 * @method static array getSupplier(array $array = [])
 * @method static array postSupplier(array $array = [])
 * @method static array deleteSupplier(array $array = [])
 * @method static array getTeams(array $array = [])
 * @method static array getTeam(array $array = [])
 * @method static array postTeam(array $array = [])
 * @method static array deleteTeam(array $array = [])
 * @method static array getTicketTypes(array $array = [])
 * @method static array getTicketType(array $array = [])
 * @method static array postTicketType(array $array = [])
 * @method static array deleteTicketType(array $array = [])
 * @method static array getTickets(array $array = [])
 * @method static array getTicket(array $array = [])
 * @method static array postTicket(array $array = [])
 * @method static array deleteTicket(array $array = [])
 * @method static array getUsers(array $array = [])
 * @method static array getUser(array $array = [])
 * @method static array postUser(array $array = [])
 * @method static array deleteUser(array $array = [])
 *
 * @see \DerrickSmith\HaloApi\HaloApi
 */
class Halo extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return HaloApi::class;
    }
}
